import React from 'react';
import { Link, usePage, Head } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function UserIndex({ users }) {
    const { flash } = usePage().props;
    const formatDate = (date) => date ? new Date(date).toLocaleDateString() : '-';

    return (
        <AppLayout title="Users - Law Practice Management">
            <Head><title>Users - Law Practice Management</title></Head>
            <div className="page-header">
                <div><h1 className="page-title">Users</h1><p className="page-subtitle">Manage system users</p></div>
            </div>
            {flash.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="card border-light shadow-sm">
                <div className="table-responsive">
                    <table className="table-custom">
                        <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Created</th><th className="text-center">Actions</th></tr></thead>
                        <tbody>{users.data.map((user) => (
                            <tr key={user.id}>
                                <td>{user.name}</td><td>{user.email}</td>
                                <td><span className="badge bg-secondary">{user.role || 'User'}</span></td>
                                <td>{formatDate(user.created_at)}</td>
                                <td><div className="d-flex justify-content-center gap-1">
                                    <Link href={`/user/${user.id}/edit`} className="table-btn-action" title="Edit"><i className="bi bi-pencil"></i></Link>
                                    <form onSubmit={(e) => { e.preventDefault(); if (confirm('Delete this user?')) e.currentTarget.submit(); }} action={`/user/${user.id}`} method="POST">
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
                    <span className="table-pagination-info">Showing {users.from} to {users.to} of {users.total} entries</span>
                    <nav aria-label="Page navigation"><ul className="pagination mb-0 gap-1">
                        {users.prev_page_url && <li className="page-item"><a className="page-link border-0" href={users.prev_page_url}><i className="bi bi-chevron-left"></i></a></li>}
                        {Array.from({ length: users.last_page }, (_, i) => i + 1).map((page) => <li key={page} className={`page-item ${users.current_page === page ? 'active' : ''}`}><a className="page-link border-0" href={`${route('user.index')}?page=${page}`}>{page}</a></li>)}
                        {users.next_page_url && <li className="page-item"><a className="page-link border-0" href={users.next_page_url}><i className="bi bi-chevron-right"></i></a></li>}
                    </ul></nav>
                </div>
            </div>
        </AppLayout>
    );
}