import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function FileIndex({ lawCase, files }) {
    const { flash = {} } = usePage().props;

    const formatSize = (bytes) => {
        if (!bytes) return '-';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    };

    const formatDate = (date) => {
        if (!date) return '-';
        return new Date(date).toLocaleDateString();
    };

    return (
        <AppLayout title={`Case Files - Case #${lawCase.id} - Law Practice Management`}>
            <div class="page-header">
                <div>
                    <h1 class="page-title">Case Files</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
                <Link href={`/law-cases/${lawCase.id}/files/create`} class="btn-custom btn-custom-primary">
                    <i class="bi bi-upload"></i> Upload File
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
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Uploaded By</th>
                                <th>Uploaded</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {files.data.map((file) => (
                                <tr key={file.id}>
                                    <td>
                                        <div class="table-user-name">{file.filename}</div>
                                    </td>
                                    <td>{formatSize(file.file_size)}</td>
                                    <td>{file.uploaded_by || '-'}</td>
                                    <td>{formatDate(file.created_at)}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href={`/storage/${file.file_path}`} target="_blank" class="table-btn-action" title="Download">
                                                <i class="bi bi-download"></i>
                                            </a>
                                            <form onSubmit={(e) => {
                                                e.preventDefault();
                                                if (confirm('Are you sure you want to delete this file?')) {
                                                    e.currentTarget.submit();
                                                }
                                            }} action={`/law-cases/${lawCase.id}/files/${file.id}`} method="POST">
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
                        Showing {files.from} to {files.to} of {files.total} entries
                    </span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0 gap-1">
                            {files.prev_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={files.prev_page_url}><i class="bi bi-chevron-left"></i></a>
                                </li>
                            )}
                            {Array.from({ length: files.last_page }, (_, i) => i + 1).map((page) => (
                                <li key={page} className={`page-item ${files.current_page === page ? 'active' : ''}`}>
                                    <a class="page-link border-0" href={`/law-cases/${lawCase.id}/files?page=${page}`}>{page}</a>
                                </li>
                            ))}
                            {files.next_page_url && (
                                <li class="page-item">
                                    <a class="page-link border-0" href={files.next_page_url}><i class="bi bi-chevron-right"></i></a>
                                </li>
                            )}
                        </ul>
                    </nav>
                </div>
            </div>
        </AppLayout>
    );
}
