const pad = (value) => String(value).padStart(2, '0');

export const formatDate = (date) => [
    date.getFullYear(),
    pad(date.getMonth() + 1),
    pad(date.getDate()),
].join('-');

export const parseDate = (value) => {
    const [year, month, day] = value.split('-').map(Number);

    return new Date(year, month - 1, day);
};

export const addDays = (date, days) => {
    const nextDate = new Date(date);
    nextDate.setDate(nextDate.getDate() + days);

    return nextDate;
};

export const getVisibleRange = (view, anchorDate) => {
    if (view === 'week') {
        const start = new Date(anchorDate);
        start.setDate(start.getDate() - start.getDay());

        return { start, end: addDays(start, 6) };
    }

    if (view === 'day') {
        return { start: new Date(anchorDate), end: new Date(anchorDate) };
    }

    const start = new Date(anchorDate.getFullYear(), anchorDate.getMonth(), 1);
    start.setDate(start.getDate() - start.getDay());

    const end = new Date(anchorDate.getFullYear(), anchorDate.getMonth() + 1, 0);
    end.setDate(end.getDate() + (6 - end.getDay()));

    return { start, end };
};

export const buildDateRange = (start, end) => {
    const dates = [];
    let currentDate = new Date(start);

    while (currentDate <= end) {
        dates.push(new Date(currentDate));
        currentDate = addDays(currentDate, 1);
    }

    return dates;
};

export const shiftAnchor = (view, anchorDate, offset) => {
    if (view === 'month') {
        return new Date(anchorDate.getFullYear(), anchorDate.getMonth() + offset, 1);
    }

    if (view === 'week') {
        return addDays(anchorDate, offset * 7);
    }

    return addDays(anchorDate, offset);
};

export const formatPeriod = (view, range) => {
    if (view === 'month') {
        return range.start.toLocaleDateString('en-US', {
            month: 'long',
            year: 'numeric',
        });
    }

    if (view === 'day') {
        return range.start.toLocaleDateString('en-US', {
            month: 'long',
            day: 'numeric',
            year: 'numeric',
        });
    }

    const start = range.start.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
    });
    const end = range.end.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });

    return `${start} – ${end}`;
};

export const formatDuration = (value) => Number(value || 0).toFixed(2).replace(/\.00$/, '');
