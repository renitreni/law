import React from 'react';
import { useForm, Head, usePage, Link } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function OptionsIndex({ clients }) {
    const { flash = {} } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({ name: '', code: '' });

    const handleSubmit = (e) => {
        e.preventDefault();
        post('/options', { onSuccess: () => reset() });
    };

    return (
        <AppLayout title="Options - Law Practice Management">
            <Head><title>Options - Law Practice Management</title></Head>
            <div className="page-header">
                <div><h1 className="page-title">Options</h1><p className="page-subtitle">Manage system options</p></div>
            </div>
            {flash?.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="row">
                <div className="col-12 col-lg-8">
                    <div className="card border-light shadow-sm">
                        <div className="card-header"><h2 className="card-title">Clients</h2></div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit} className="mb-4 p-3 bg-light rounded">
                                <div className="row g-3">
                                    <div className="col-md-6">
                                        <label className="form-label-custom">Client Name <span className="text-danger">*</span></label>
                                        <input type="text" className={`form-control-custom ${errors.name ? 'is-invalid-custom' : ''}`} value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="Enter client name" required />
                                        {errors.name && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.name}</div>}
                                    </div>
                                    <div className="col-md-6">
                                        <label className="form-label-custom">Client Code <span className="text-danger">*</span></label>
                                        <input type="text" className={`form-control-custom ${errors.code ? 'is-invalid-custom' : ''}`} value={data.code} onChange={(e) => setData('code', e.target.value)} placeholder="Enter client code" required />
                                        {errors.code && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.code}</div>}
                                    </div>
                                </div>
                                <div className="d-flex gap-2 mt-3">
                                    <button type="submit" className="btn-custom btn-custom-primary" disabled={processing}>{processing ? <><span className="spinner-border spinner-border-sm me-2"></span>Adding...</> : <><i className="bi bi-check-lg"></i> Add Client</>}</button>
                                </div>
                            </form>
                            <div className="table-responsive">
                                <table className="table-custom">
                                    <thead><tr><th>Name</th><th>Code</th><th className="text-center">Actions</th></tr></thead>
                                    <tbody>{clients.data.map((client) => (
                                        <tr key={client.id}>
                                            <td>{client.name}</td><td>{client.code}</td>
                                            <td><div className="d-flex justify-content-center gap-1">
                                                <form onSubmit={(e) => { e.preventDefault(); if (confirm('Are you sure you want to delete this client?')) e.currentTarget.submit(); }} action={`/options/${client.id}`} method="POST">
                                                    <input type="hidden" name="_method" value="DELETE" />
                                                    <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                                                    <button type="submit" className="table-btn-action delete" title="Delete"><i className="bi bi-trash"></i></button>
                                                </form>
                                            </div></td>
                                        </tr>
                                    ))}</tbody>
                                </table>
                            </div>
                            <div className="table-footer-control">
                                <span className="table-pagination-info">Showing {clients.from} to {clients.to} of {clients.total} entries</span>
                                <nav aria-label="Page navigation"><ul className="pagination mb-0 gap-1">
                                    {clients.prev_page_url && <li className="page-item"><a className="page-link border-0" href={clients.prev_page_url}><i className="bi bi-chevron-left"></i></a></li>}
                                    {Array.from({ length: clients.last_page }, (_, i) => i + 1).map((page) => <li key={page} className={`page-item ${clients.current_page === page ? 'active' : ''}`}><a className="page-link border-0" href={`/options?page=${page}`}>{page}</a></li>)}
                                    {clients.next_page_url && <li className="page-item"><a className="page-link border-0" href={clients.next_page_url}><i className="bi bi-chevron-right"></i></a></li>}
                                </ul></nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
