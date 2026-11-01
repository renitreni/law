import React from 'react';
import { useForm, Head, usePage, Link } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function GalleryIndex({ photos }) {
    const { flash = {} } = usePage().props;
    const { data, setData, post, processing, errors, reset } = useForm({
        photos: [],
    });

    const handleFileChange = (e) => {
        setData('photos', Array.from(e.target.files));
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('gallery.store'), { forceFormData: true, onSuccess: () => reset() });
    };

    return (
        <AppLayout title="Gallery - Law Practice Management">
            <Head><title>Gallery - Law Practice Management</title></Head>
            <div className="page-header">
                <div><h1 className="page-title">Gallery</h1><p className="page-subtitle">Manage photo gallery</p></div>
            </div>
            {flash?.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="row">
                <div className="col-12 col-lg-6">
                    <div className="card border-light shadow-sm mb-4">
                        <div className="card-header"><h2 className="card-title">Upload Photos</h2></div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit} encType="multipart/form-data">
                                <div className="mb-3">
                                    <label className="form-label-custom">Select Photos <span className="text-danger">*</span></label>
                                    <input type="file" className={`form-control-custom ${errors.photos ? 'is-invalid-custom' : ''}`} multiple accept="image/*" onChange={handleFileChange} required />
                                    {errors.photos && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.photos}</div>}
                                    <div className="form-text">Max 5MB per image. Multiple files allowed.</div>
                                </div>
                                <button type="submit" className="btn-custom btn-custom-primary" disabled={processing}>{processing ? <><span className="spinner-border spinner-border-sm me-2"></span>Uploading...</> : <><i className="bi bi-upload"></i> Upload Photos</>}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div className="card border-light shadow-sm">
                <div className="card-header"><h2 className="card-title">Photos</h2></div>
                <div className="card-body">
                    {photos.data.length === 0 ? (
                        <div className="text-center py-5"><i className="bi bi-images text-muted" style={{fontSize: '3rem'}}></i><h4 className="mt-3">No photos yet</h4><p className="text-muted">Upload your first photo using the form above.</p></div>
                    ) : (
                        <div className="row g-3">
                            {photos.data.map((photo) => (
                                <div key={photo.id} className="col-6 col-md-4 col-lg-3">
                                    <div className="card border-light shadow-sm h-100">
                                        <img src={`/storage/gallery/${photo.photo_name}`} alt={photo.photo_name} className="card-img-top" style={{height: '200px', objectFit: 'cover'}} />
                                        <div className="card-body p-2 d-flex justify-content-between">
                                            <small className="text-muted text-truncate">{photo.photo_name}</small>
                                            <form onSubmit={(e) => { e.preventDefault(); if (confirm('Delete this photo?')) e.currentTarget.submit(); }} action={route('gallery.destroy', photo)} method="POST">
                                                <input type="hidden" name="_method" value="DELETE" />
                                                <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                                                <button type="submit" className="btn btn-sm btn-outline-danger p-1" title="Delete"><i className="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                    <div className="table-footer-control mt-3">
                        <span className="table-pagination-info">Showing {photos.from} to {photos.to} of {photos.total} entries</span>
                        <nav aria-label="Page navigation"><ul className="pagination mb-0 gap-1">
                            {photos.prev_page_url && <li className="page-item"><a className="page-link border-0" href={photos.prev_page_url}><i className="bi bi-chevron-left"></i></a></li>}
                            {Array.from({ length: photos.last_page }, (_, i) => i + 1).map((page) => <li key={page} className={`page-item ${photos.current_page === page ? 'active' : ''}`}><a className="page-link border-0" href={`${route('gallery.index')}?page=${page}`}>{page}</a></li>)}
                            {photos.next_page_url && <li className="page-item"><a className="page-link border-0" href={photos.next_page_url}><i className="bi bi-chevron-right"></i></a></li>}
                        </ul></nav>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}