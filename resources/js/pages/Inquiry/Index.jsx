import React from 'react';
import { Link, usePage, Head } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function InquiryIndex({ inquiries }) {
    const { flash = {} } = usePage().props;
    const formatDate = (date) => date ? new Date(date).toLocaleDateString() : '-';

    return (
        <AppLayout title="Inquiries - Law Practice Management">
            <Head><title>Inquiries - Law Practice Management</title></Head>
            <div className="page-header">
                <div><h1 className="page-title">Inquiries</h1><p className="page-subtitle">Manage client inquiries</p></div>
            </div>
            {flash?.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="card border-light shadow-sm">
                <div className="table-responsive">
                    <table className="table-custom">
                        <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Legal Issue</th><th>Date</th><th className="text-center">Actions</th></tr></thead>
                        <tbody>{inquiries.data.map((inquiry) => (
                            <tr key={inquiry.id}>
                                <td>{inquiry.firstname} {inquiry.lastname}</td>
                                <td>{inquiry.email}</td>
                                <td>{inquiry.phonenumber}</td>
                                <td><span className="badge bg-primary">{inquiry.legalIssue}</span></td>
                                <td>{formatDate(inquiry.created_at)}</td>
                                <td><div className="d-flex justify-content-center gap-1">
                                    <Link href={`/inquiry/${inquiry.id}`} className="table-btn-action" title="View"><i className="bi bi-eye"></i></Link>
                                    <form onSubmit={(e) => { e.preventDefault(); if (confirm('Delete this inquiry?')) e.currentTarget.submit(); }} action={`/inquiry/${inquiry.id}`} method="POST">
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
                    <span className="table-pagination-info">Showing {inquiries.from} to {inquiries.to} of {inquiries.total} entries</span>
                    <nav aria-label="Page navigation"><ul className="pagination mb-0 gap-1">
                        {inquiries.prev_page_url && <li className="page-item"><a className="page-link border-0" href={inquiries.prev_page_url}><i className="bi bi-chevron-left"></i></a></li>}
                        {Array.from({ length: inquiries.last_page }, (_, i) => i + 1).map((page) => <li key={page} className={`page-item ${inquiries.current_page === page ? 'active' : ''}`}><a className="page-link border-0" href={`${route('inquiry.index')}?page=${page}`}>{page}</a></li>)}
                        {inquiries.next_page_url && <li className="page-item"><a className="page-link border-0" href={inquiries.next_page_url}><i className="bi bi-chevron-right"></i></a></li>}
                    </ul></nav>
                </div>
            </div>
        </AppLayout>
    );
}