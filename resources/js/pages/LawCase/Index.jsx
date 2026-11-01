import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function Index({ cases }) {
    const { flash } = usePage().props;

    return (
        <AppLayout title="Cases - Law Practice Management">
            <div class="page-header">
                <div>
                    <h1 class="page-title">Cases</h1>
                    <p class="page-subtitle">Manage your law cases efficiently</p>
                </div>
                <Link href="/law-cases/create" class="btn-custom btn-custom-primary">
                    <i class="bi bi-plus-lg"></i> New Case
                </Link>
            </div>

            {flash.success && (
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {flash.success}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            )}

            <div class="table-card-custom">
                <div class="table-header-control">
                    <div class="table-search-box">
                        <i class="bi bi-search table-search-icon"></i>
                        <input type="text" class="table-search-input" placeholder="Search cases..." />
                    </div>
                    <div class="table-filter-group">
                        <div class="dropdown">
                            <button class="btn-table-action dropdown-toggle" type="button" id="dropdownFilterStatus"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i> Status Filter
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownFilterStatus">
                                <li><a class="dropdown-item" href="#">All Statuses</a></li>
                                <li><a class="dropdown-item" href="#">Open</a></li>
                                <li><a class="dropdown-item" href="#">In Progress</a></li>
                                <li><a class="dropdown-item" href="#">Closed</a></li>
                                <li><a class="dropdown-item" href="#">Pending</a></li>
                            </ul>
                        </div>
                        <button class="btn-table-action" type="button">
                            <i class="bi bi-file-earmark-arrow-down"></i> Export
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Case ID</th>
                                <th>Plaintiff</th>
                                <th>Defendant</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Attorney</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {cases.data.map((caseItem) => (
                                <tr key={caseItem.id}>
                                    <td class="table-order-id">#{caseItem.id}</td>
                                    <td>
                                        <div class="table-user-name">{caseItem.case_plaintiff}</div>
                                    </td>
                                    <td>{caseItem.case_defendant}</td>
                                    <td>{caseItem.case_category}</td>
                                    <td>
                                        <span className={`badge-table ${getStatusBadgeClass(caseItem.case_status)}`}>
                                            {caseItem.case_status}
                                        </span>
                                    </td>
                                    <td>{caseItem.case_date ? new Date(caseItem.case_date).toLocaleDateString() : '-'}</td>
                                    <td>{caseItem.case_attorney || '-'}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <Link href={`/law-cases/${caseItem.id}`} class="table-btn-action" title="View details">
                                                <i class="bi bi-eye"></i>
                                            </Link>
                                            <Link href={`/law-cases/${caseItem.id}/edit`} class="table-btn-action" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </Link>
                                            <form onSubmit={(e) => {
                                                e.preventDefault();
                                                if (confirm('Are you sure you want to delete this case?')) {
                                                    e.currentTarget.submit();
                                                }
                                            }} action={`/law-cases/${caseItem.id}`} method="POST">
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
                        Showing {cases.from} to {cases.to} of {cases.total} entries
                    </span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0 gap-1">
                            {cases.prev_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={cases.prev_page_url}><i class="bi bi-chevron-left"></i></a>
                                </li>
                            )}
                            {Array.from({ length: cases.last_page }, (_, i) => i + 1).map((page) => (
                                <li key={page} className={`page-item ${cases.current_page === page ? 'active' : ''}`}>
                                    <a class="page-link border-0" href={`/law-cases?page=${page}`}>{page}</a>
                                </li>
                            ))}
                            {cases.next_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={cases.next_page_url}><i class="bi bi-chevron-right"></i></a>
                                </li>
                            )}
                        </ul>
                    </nav>
                </div>
            </div>
        </AppLayout>
    );
}

function getStatusBadgeClass(status) {
    const statusLower = status?.toLowerCase();
    if (statusLower === 'open') return 'success';
    if (statusLower === 'closed') return 'failed';
    if (statusLower === 'in progress' || statusLower === 'pending') return 'pending';
    return 'pending';
}
