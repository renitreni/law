import React, { useEffect, useMemo, useState } from 'react';
import axios from 'axios';
import {
    buildDateRange,
    formatDate,
    formatDuration,
    formatPeriod,
    getVisibleRange,
    parseDate,
    shiftAnchor,
} from './calendarUtils';
import './TimeEntryCalendar.css';

const WEEKDAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
const VIEWS = ['month', 'week', 'day'];

function SummaryTotals({ summary }) {
    const hasEntries = summary && ['posted', 'draft', 'billable', 'non_billable']
        .some((key) => Number(summary[key]) > 0);

    if (!hasEntries) {
        return <span className="calendar-empty-day">No entries</span>;
    }

    return (
        <dl className="calendar-summary">
            {[
                ['Posted', summary.posted],
                ['Draft', summary.draft],
                ['Billable', summary.billable],
                ['Non-billable', summary.non_billable],
            ].map(([label, value]) => (
                <div className="calendar-summary-row" key={label}>
                    <dt>{label}</dt>
                    <dd>{formatDuration(value)}</dd>
                </div>
            ))}
        </dl>
    );
}

function CalendarDayButton({
    date,
    view,
    anchorDate,
    selectedDate,
    summary,
    onSelect,
}) {
    const dateKey = formatDate(date);
    const todayKey = formatDate(new Date());
    const classes = ['calendar-day'];

    if (view === 'month' && date.getMonth() !== anchorDate.getMonth()) {
        classes.push('is-outside-month');
    }

    if (dateKey === selectedDate) {
        classes.push('is-selected');
    }

    if (dateKey === todayKey) {
        classes.push('is-today');
    }

    const accessibleDate = date.toLocaleDateString('en-US', {
        weekday: 'long',
        month: 'long',
        day: 'numeric',
        year: 'numeric',
    });

    return (
        <div className={classes.join(' ')}>
            <button
                type="button"
                className="calendar-day-button"
                onClick={() => onSelect(dateKey)}
                aria-label={`View entries for ${accessibleDate}`}
                aria-pressed={dateKey === selectedDate}
            >
                <span className="calendar-day-heading">
                    <span className="calendar-day-number">{date.getDate()}</span>
                    {(view !== 'month' || date.getMonth() !== anchorDate.getMonth()) && (
                        <span className="calendar-day-month">
                            {date.toLocaleDateString('en-US', { month: 'short' })}
                        </span>
                    )}
                </span>
                <SummaryTotals summary={summary} />
            </button>
        </div>
    );
}

const relationLabel = (relation, fallback) => (
    relation ? `${relation.code?.toUpperCase()} - ${relation.name}` : fallback
);

function EntryDetails({
    details,
    selectedDate,
    loading,
    error,
    onRetry,
}) {
    const formattedDate = parseDate(selectedDate).toLocaleDateString('en-US', {
        month: 'long',
        day: 'numeric',
        year: 'numeric',
    });

    return (
        <section aria-live="polite" aria-label="Selected day entries">
            <div className="calendar-details-header">
                <h3 className="calendar-details-title">Entries for {formattedDate}</h3>
                {loading && <span className="calendar-status">Loading…</span>}
            </div>

            {error && (
                <div className="alert alert-danger mt-3 d-flex align-items-center justify-content-between" role="alert">
                    <span>{error}</span>
                    <button type="button" className="btn btn-sm btn-outline-danger" onClick={onRetry}>
                        Retry
                    </button>
                </div>
            )}

            {!loading && !error && details.length === 0 && (
                <div className="calendar-empty-details">
                    No time entries have been recorded for this date.
                </div>
            )}

            <div className="calendar-detail-list">
                {details.map((entry) => (
                    <article className="calendar-detail-item" key={entry.id}>
                        <div className="calendar-detail-heading">
                            <h4 className="calendar-detail-title">
                                {relationLabel(entry.clients, 'Unassigned client')}
                            </h4>
                            <div className="calendar-detail-badges">
                                <span className={`badge ${entry.is_draft ? 'bg-warning text-dark' : 'bg-success'}`}>
                                    {entry.is_draft ? 'Draft' : 'Posted'}
                                </span>
                                <span className={`badge ${entry.is_billable ? 'bg-primary' : 'bg-danger'}`}>
                                    {entry.is_billable ? 'Billable' : 'Non-billable'}
                                </span>
                            </div>
                        </div>

                        <div className="calendar-detail-meta">
                            <span>Duration: <strong>{formatDuration(entry.duration)}</strong></span>
                            <span>Matter: {relationLabel(entry.submatters, 'Unassigned')}</span>
                            <span>Office: {relationLabel(entry.offices, 'Unassigned')}</span>
                        </div>

                        {entry.narrative && <p className="calendar-detail-narrative">{entry.narrative}</p>}
                    </article>
                ))}
            </div>
        </section>
    );
}

export default function TimeEntryCalendar() {
    const [view, setView] = useState('month');
    const [anchorDate, setAnchorDate] = useState(() => new Date());
    const [selectedDate, setSelectedDate] = useState(() => formatDate(new Date()));
    const [summaries, setSummaries] = useState({});
    const [details, setDetails] = useState([]);
    const [summaryLoading, setSummaryLoading] = useState(true);
    const [detailsLoading, setDetailsLoading] = useState(true);
    const [summaryError, setSummaryError] = useState('');
    const [detailsError, setDetailsError] = useState('');
    const [summaryReloadToken, setSummaryReloadToken] = useState(0);
    const [detailsReloadToken, setDetailsReloadToken] = useState(0);

    const range = useMemo(() => getVisibleRange(view, anchorDate), [view, anchorDate]);
    const startDate = formatDate(range.start);
    const endDate = formatDate(range.end);
    const visibleDates = useMemo(
        () => buildDateRange(range.start, range.end),
        [range]
    );

    useEffect(() => {
        const controller = new AbortController();

        setSummaryLoading(true);
        setSummaryError('');

        axios.get('/timesheet/calendar', {
            params: { start: startDate, end: endDate },
            signal: controller.signal,
        })
            .then((response) => {
                const entries = response.data.data || [];
                setSummaries(Object.fromEntries(entries.map((entry) => [entry.date, entry])));
            })
            .catch((error) => {
                if (error.name === 'CanceledError') {
                    return;
                }

                setSummaries({});
                setSummaryError(error.response?.data?.message || 'Unable to load the calendar summary.');
            })
            .finally(() => {
                if (!controller.signal.aborted) {
                    setSummaryLoading(false);
                }
            });

        return () => controller.abort();
    }, [startDate, endDate, summaryReloadToken]);

    useEffect(() => {
        const controller = new AbortController();

        setDetailsLoading(true);
        setDetailsError('');

        axios.get('/timesheet/entries', {
            params: { date: selectedDate },
            signal: controller.signal,
        })
            .then((response) => setDetails(response.data.data || []))
            .catch((error) => {
                if (error.name === 'CanceledError') {
                    return;
                }

                setDetails([]);
                setDetailsError(error.response?.data?.message || 'Unable to load the selected day.');
            })
            .finally(() => {
                if (!controller.signal.aborted) {
                    setDetailsLoading(false);
                }
            });

        return () => controller.abort();
    }, [selectedDate, detailsReloadToken]);

    const changeView = (nextView) => {
        setView(nextView);
        setSelectedDate(formatDate(getVisibleRange(nextView, anchorDate).start));
    };

    const navigate = (offset) => {
        const nextAnchorDate = shiftAnchor(view, anchorDate, offset);
        setAnchorDate(nextAnchorDate);
        setSelectedDate(formatDate(getVisibleRange(view, nextAnchorDate).start));
    };

    const showToday = () => {
        const today = new Date();
        setAnchorDate(today);
        setSelectedDate(formatDate(today));
    };

    return (
        <div className="time-entry-calendar">
            <div className="calendar-toolbar d-flex flex-column flex-lg-row align-items-lg-center">
                <div className="btn-group" role="group" aria-label="Calendar view">
                    {VIEWS.map((calendarView) => (
                        <button
                            key={calendarView}
                            type="button"
                            className={`btn btn-sm ${view === calendarView ? 'btn-primary' : 'btn-outline-primary'}`}
                            onClick={() => changeView(calendarView)}
                            aria-pressed={view === calendarView}
                        >
                            {calendarView.charAt(0).toUpperCase() + calendarView.slice(1)}
                        </button>
                    ))}
                </div>

                <div className="calendar-period">
                    <button type="button" className="btn btn-sm btn-outline-secondary" onClick={() => navigate(-1)}>
                        <i className="bi bi-chevron-left" aria-hidden="true"></i>
                        <span className="visually-hidden">Previous {view}</span>
                    </button>
                    <p className="calendar-period-label">{formatPeriod(view, range)}</p>
                    <button type="button" className="btn btn-sm btn-outline-secondary" onClick={() => navigate(1)}>
                        <i className="bi bi-chevron-right" aria-hidden="true"></i>
                        <span className="visually-hidden">Next {view}</span>
                    </button>
                    <button type="button" className="btn btn-sm btn-outline-secondary" onClick={showToday}>
                        Today
                    </button>
                </div>
            </div>

            {summaryLoading && (
                <div className="calendar-loading" role="status">
                    <span className="spinner-border spinner-border-sm" aria-hidden="true"></span>
                    Loading calendar…
                </div>
            )}

            {summaryError && (
                <div className="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                    <span>{summaryError}</span>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-danger"
                        onClick={() => setSummaryReloadToken((token) => token + 1)}
                    >
                        Retry
                    </button>
                </div>
            )}

            <div className="d-none d-md-block calendar-weekdays" aria-hidden="true">
                {WEEKDAYS.map((weekday) => (
                    <div className="calendar-weekday" key={weekday}>{weekday}</div>
                ))}
            </div>

            <div className={`calendar-days ${view === 'day' ? 'is-day-view' : ''}`}>
                {visibleDates.map((date) => {
                    const dateKey = formatDate(date);

                    return (
                        <CalendarDayButton
                            key={dateKey}
                            date={date}
                            view={view}
                            anchorDate={anchorDate}
                            selectedDate={selectedDate}
                            summary={summaries[dateKey]}
                            onSelect={setSelectedDate}
                        />
                    );
                })}
            </div>

            <EntryDetails
                details={details}
                selectedDate={selectedDate}
                loading={detailsLoading}
                error={detailsError}
                onRetry={() => setDetailsReloadToken((token) => token + 1)}
            />
        </div>
    );
}
