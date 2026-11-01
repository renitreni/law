import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function ClientIndex({ lawCase, clients }) {
    const { flash = {} } = usePage().props;

    return (
        <AppLayout title={`Clients - Case #${lawCase.id} - Law Practice Management`}>
            <div class="page-header">
                <div>
                    <h1 class="page-title">Clients</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
                <Link href={`/law-cases/${lawCase.id}/clients/create`} class="btn-custom btn-custom-primary">
                    <i class="bi bi-plus-lg"></i> Add Client
                </Link>
            </div>

            {flash?.success && (
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {flash.success}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            )}

            <Link href={`/law-cases/${lawCase.id}`} class="btn-custom btn-custom-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Case
            </Link>

            <div class="table-card-custom">
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Client Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Company</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {clients.data.map((client) => (
                                <tr key={client.id}>
                                    <td>
                                        <div class="table-user-name">{client.client_name}</div>
                                    </td>
                                    <td>{client.client_contact || '-'}</td>
                                    <td>{client.client_email || '-'}</td>
                                    <td>{client.client_company || '-'}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <Link href={`/law-cases/${lawCase.id}/clients/${client.id}`} class="table-btn-action" title="View">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link href={`/law-cases/${lawCase.id}/clients/${client.id}/edit`} class="table-btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </Link>
                                            <form onSubmit={(e) => {
                                                e.preventDefault();
                                                if (confirm('Are you sure you want to delete this client?')) {
                                                    e.currentTarget.submit();
                                                }
                                            }} action={`/law-cases/${lawCase.id}/clients/${client.id}`} method="POST">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                                                <button type="submit" class="table-btn-action delete" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                <div class="table-footer-control">
                    <span class="table-pagination-info">
                        Showing {clients.from} to {clients.to} of {clients.total} entries
                    </span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0 gap-1">
                            {clients.prev_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={clients.prev_page_url}><i class="bi bi-chevron-left"></i></a>
                                </li>
                            )}
                            {Array.from({ length: clients.last_page }, (_, i) => i + 1).map((page) => (
                                <li key={page} className={`page-item ${clients.current_page === page ? 'active' : ''}`}>
                                    <a class="page-link border-0" href={`/law-cases/${lawCase.id}/clients?page=${page}`}>{page}</a>
                                </li>
                            ))}
                            {clients.next_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={clients.next_page_url}><i class="bi bi-chevron-right"></i></a>
                                </li>
                            )}
                        </ul>
                    </nav>
                </div>
            </div>
        </AppLayout>
    );
}
