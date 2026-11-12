import React, { useEffect, useMemo, useState } from 'react';
import axios from 'axios';

const EMPTY_FORM = {
    entry_date: '',
    duration: '',
    client_id: '',
    matter_id: '',
    sub_matter_id: '',
    office_id: '',
    narrative: '',
    is_billable: true,
    is_template: false,
    template_name: '',
};

const toDateString = (value) => String(value || '').slice(0, 10);

const relationLabel = (relation) => (
    relation ? `${relation.code?.toUpperCase()} - ${relation.name}` : ''
);

function SearchableSelect({
    id,
    value,
    onChange,
    options,
    placeholder,
    disabled = false,
    error = '',
}) {
    const [query, setQuery] = useState('');

    const filtered = useMemo(() => {
        const selected = options.find((option) => option.value === value);
        const remainder = options.filter((option) => option.value !== value);
        const candidates = selected ? [selected, ...remainder] : options;
        const needle = query.trim().toLowerCase();

        if (!needle) {
            return candidates;
        }

        return candidates.filter((option) => option.label.toLowerCase().includes(needle));
    }, [options, query, value]);

    return (
        <div className="time-entry-select">
            <input
                type="text"
                className="form-control form-control-sm time-entry-select-search"
                placeholder="Type to filter…"
                value={query}
                onChange={(event) => setQuery(event.target.value)}
                disabled={disabled}
                aria-label={`Filter ${placeholder}`}
            />
            <select
                id={id}
                className={`form-select form-select-sm ${error ? 'is-invalid' : ''}`}
                value={value}
                onChange={(event) => onChange(event.target.value)}
                disabled={disabled || filtered.length === 0}
            >
                <option value="">{placeholder}</option>
                {filtered.map((option) => (
                    <option key={option.value} value={option.value}>
                        {option.label}
                    </option>
                ))}
            </select>
            {error && <div className="invalid-feedback d-block">{error}</div>}
        </div>
    );
}

function FieldError({ message }) {
    if (!message) {
        return null;
    }

    return <div className="invalid-feedback d-block">{message}</div>;
}

export default function TimeEntryModal({
    show,
    entry,
    clients,
    matters,
    offices,
    templates,
    defaultDate,
    onClose,
    onSaved,
}) {
    const [form, setForm] = useState(EMPTY_FORM);
    const [templateId, setTemplateId] = useState('');
    const [errors, setErrors] = useState({});
    const [saving, setSaving] = useState(false);
    const [saveError, setSaveError] = useState('');

    useEffect(() => {
        if (!show) {
            return;
        }

        setErrors({});
        setSaveError('');
        setTemplateId('');

        if (entry) {
            setForm({
                entry_date: toDateString(entry.entry_date) || defaultDate,
                duration: entry.duration ?? '',
                client_id: entry.client_id ? String(entry.client_id) : '',
                matter_id: entry.matter_id ? String(entry.matter_id) : '',
                sub_matter_id: entry.sub_matter_id ? String(entry.sub_matter_id) : '',
                office_id: entry.office_id ? String(entry.office_id) : '',
                narrative: entry.narrative || '',
                is_billable: Boolean(entry.is_billable),
                is_template: false,
                template_name: '',
            });
        } else {
            setForm({ ...EMPTY_FORM, entry_date: defaultDate });
        }
    }, [show, entry, defaultDate]);

    useEffect(() => {
        if (!show) {
            return undefined;
        }

        const onKeyDown = (event) => {
            if (event.key === 'Escape' && !saving) {
                onClose();
            }
        };

        window.addEventListener('keydown', onKeyDown);

        return () => window.removeEventListener('keydown', onKeyDown);
    }, [show, saving, onClose]);

    const clientOptions = useMemo(
        () => clients.map((client) => ({
            value: String(client.id),
            label: relationLabel(client) || client.name,
        })),
        [clients]
    );

    const matterOptions = useMemo(
        () => matters.map((matter) => ({
            value: String(matter.id),
            label: relationLabel(matter) || matter.name,
        })),
        [matters]
    );

    const selectedMatter = useMemo(
        () => matters.find((matter) => String(matter.id) === form.matter_id),
        [matters, form.matter_id]
    );

    const subMatterOptions = useMemo(() => {
        const subMatters = selectedMatter?.sub_matters || selectedMatter?.subMatters || [];

        return subMatters.map((subMatter) => ({
            value: String(subMatter.id),
            label: relationLabel(subMatter) || subMatter.name,
        }));
    }, [selectedMatter]);

    const officeOptions = useMemo(
        () => offices.map((office) => ({
            value: String(office.id),
            label: relationLabel(office) || office.name,
        })),
        [offices]
    );

    const updateField = (field, value) => {
        setForm((current) => {
            const next = { ...current, [field]: value };

            if (field === 'matter_id') {
                next.sub_matter_id = '';
            }

            return next;
        });

        if (errors[field]) {
            setErrors((current) => ({ ...current, [field]: undefined }));
        }
    };

    const applyTemplate = (id) => {
        setTemplateId(id);

        const template = templates.find((item) => String(item.id) === id);

        if (!template) {
            return;
        }

        setForm((current) => ({
            ...current,
            client_id: template.client_id ? String(template.client_id) : '',
            matter_id: template.matter_id ? String(template.matter_id) : '',
            sub_matter_id: template.sub_matter_id ? String(template.sub_matter_id) : '',
            office_id: template.office_id ? String(template.office_id) : '',
            duration: template.duration ?? current.duration,
            narrative: template.narrative || '',
            is_billable: Boolean(template.is_billable),
        }));
        setErrors({});
    };

    const toggleSaveAsTemplate = (checked) => {
        updateField('is_template', checked);

        if (!checked && errors.template_name) {
            setErrors((current) => ({ ...current, template_name: undefined }));
        }
    };

    const save = (isDraft) => {
        if (saving) {
            return;
        }

        setSaving(true);
        setSaveError('');

        const payload = {
            client_id: form.client_id,
            sub_matter_id: form.sub_matter_id,
            office_id: form.office_id,
            entry_date: form.entry_date,
            duration: form.duration,
            narrative: form.narrative,
            is_billable: form.is_billable ? 1 : 0,
            is_template: form.is_template ? 1 : 0,
            template_name: form.is_template ? form.template_name : null,
            is_draft: isDraft ? 1 : 0,
        };

        const request = entry
            ? axios.put(`/timesheet/entries/${entry.id}`, payload)
            : axios.post('/timesheet/entries', payload);

        request
            .then((response) => {
                onSaved(response.data?.data || {}, form.entry_date);
            })
            .catch((error) => {
                if (error.response?.status === 422) {
                    setErrors(error.response.data?.errors || {});
                    setSaveError('Please correct the highlighted fields.');
                } else {
                    setSaveError(error.response?.data?.message || 'Unable to save the time entry.');
                }
            })
            .finally(() => setSaving(false));
    };

    if (!show) {
        return null;
    }

    const title = entry ? 'Edit Time Entry' : 'New Time Entry';

    return (
        <div className="time-entry-modal-overlay" onClick={onClose}>
            <div
                className="time-entry-modal"
                role="dialog"
                aria-modal="true"
                aria-label={title}
                onClick={(event) => event.stopPropagation()}
            >
                <div className="time-entry-modal-header">
                    <h3 className="time-entry-modal-title">{title}</h3>
                    <button
                        type="button"
                        className="btn-close"
                        aria-label="Close"
                        onClick={onClose}
                        disabled={saving}
                    ></button>
                </div>

                <div className="time-entry-modal-body">
                    {saveError && (
                        <div className="alert alert-danger" role="alert">{saveError}</div>
                    )}

                    {templates.length > 0 && !entry && (
                        <div className="mb-3">
                            <label className="form-label" htmlFor="time-entry-template">Template</label>
                            <select
                                id="time-entry-template"
                                className="form-select form-select-sm"
                                value={templateId}
                                onChange={(event) => applyTemplate(event.target.value)}
                            >
                                <option value="">Start from a template…</option>
                                {templates.map((template) => (
                                    <option key={template.id} value={template.id}>
                                        {template.template_name}
                                    </option>
                                ))}
                            </select>
                        </div>
                    )}

                    <div className="row g-3">
                        <div className="col-12 col-md-6">
                            <label className="form-label" htmlFor="time-entry-date">Date</label>
                            <input
                                id="time-entry-date"
                                type="date"
                                className={`form-control form-control-sm ${errors.entry_date ? 'is-invalid' : ''}`}
                                value={form.entry_date}
                                onChange={(event) => updateField('entry_date', event.target.value)}
                            />
                            <FieldError message={errors.entry_date?.[0]} />
                        </div>

                        <div className="col-12 col-md-6">
                            <label className="form-label" htmlFor="time-entry-duration">Duration (hours)</label>
                            <input
                                id="time-entry-duration"
                                type="number"
                                min="0.01"
                                step="0.25"
                                className={`form-control form-control-sm ${errors.duration ? 'is-invalid' : ''}`}
                                value={form.duration}
                                onChange={(event) => updateField('duration', event.target.value)}
                            />
                            <FieldError message={errors.duration?.[0]} />
                        </div>

                        <div className="col-12">
                            <label className="form-label" htmlFor="time-entry-client">Client</label>
                            <SearchableSelect
                                id="time-entry-client"
                                value={form.client_id}
                                onChange={(value) => updateField('client_id', value)}
                                options={clientOptions}
                                placeholder="Select a client…"
                                error={errors.client_id?.[0]}
                            />
                        </div>

                        <div className="col-12 col-md-6">
                            <label className="form-label" htmlFor="time-entry-matter">Matter</label>
                            <SearchableSelect
                                id="time-entry-matter"
                                value={form.matter_id}
                                onChange={(value) => updateField('matter_id', value)}
                                options={matterOptions}
                                placeholder="Select a matter…"
                                error={errors.matter_id?.[0]}
                            />
                        </div>

                        <div className="col-12 col-md-6">
                            <label className="form-label" htmlFor="time-entry-sub-matter">Sub-matter</label>
                            <SearchableSelect
                                id="time-entry-sub-matter"
                                value={form.sub_matter_id}
                                onChange={(value) => updateField('sub_matter_id', value)}
                                options={subMatterOptions}
                                placeholder={form.matter_id ? 'Select a sub-matter…' : 'Select a matter first…'}
                                disabled={!form.matter_id}
                                error={errors.sub_matter_id?.[0]}
                            />
                        </div>

                        <div className="col-12">
                            <label className="form-label" htmlFor="time-entry-office">Office</label>
                            <SearchableSelect
                                id="time-entry-office"
                                value={form.office_id}
                                onChange={(value) => updateField('office_id', value)}
                                options={officeOptions}
                                placeholder="Select an office…"
                                error={errors.office_id?.[0]}
                            />
                        </div>

                        <div className="col-12">
                            <label className="form-label" htmlFor="time-entry-narrative">Narrative</label>
                            <textarea
                                id="time-entry-narrative"
                                className={`form-control form-control-sm ${errors.narrative ? 'is-invalid' : ''}`}
                                rows="3"
                                value={form.narrative}
                                onChange={(event) => updateField('narrative', event.target.value)}
                            ></textarea>
                            <FieldError message={errors.narrative?.[0]} />
                        </div>

                        <div className="col-12 d-flex flex-wrap gap-3">
                            <div className="form-check">
                                <input
                                    id="time-entry-billable"
                                    type="checkbox"
                                    className="form-check-input"
                                    checked={form.is_billable}
                                    onChange={(event) => updateField('is_billable', event.target.checked)}
                                />
                                <label className="form-check-label" htmlFor="time-entry-billable">
                                    Billable
                                </label>
                            </div>

                            <div className="form-check">
                                <input
                                    id="time-entry-save-template"
                                    type="checkbox"
                                    className="form-check-input"
                                    checked={form.is_template}
                                    onChange={(event) => toggleSaveAsTemplate(event.target.checked)}
                                />
                                <label className="form-check-label" htmlFor="time-entry-save-template">
                                    Save as template
                                </label>
                            </div>
                        </div>

                        {form.is_template && (
                            <div className="col-12">
                                <label className="form-label" htmlFor="time-entry-template-name">Template name</label>
                                <input
                                    id="time-entry-template-name"
                                    type="text"
                                    className={`form-control form-control-sm ${errors.template_name ? 'is-invalid' : ''}`}
                                    value={form.template_name}
                                    onChange={(event) => updateField('template_name', event.target.value)}
                                />
                                <FieldError message={errors.template_name?.[0]} />
                            </div>
                        )}
                    </div>
                </div>

                <div className="time-entry-modal-footer">
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-secondary"
                        onClick={onClose}
                        disabled={saving}
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        className="btn btn-sm btn-outline-primary"
                        onClick={() => save(true)}
                        disabled={saving}
                    >
                        {saving ? 'Saving…' : 'Save Draft'}
                    </button>
                    <button
                        type="button"
                        className="btn btn-sm btn-primary"
                        onClick={() => save(false)}
                        disabled={saving}
                    >
                        {saving ? 'Saving…' : entry ? 'Save' : 'Post'}
                    </button>
                </div>
            </div>
        </div>
    );
}
