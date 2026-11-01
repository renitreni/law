import React from 'react';
import { useForm, Head, usePage, Link } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function MatterIndex({ matters }) {
    const { flash } = usePage().props;
    const [expandedMatter, setExpandedMatter] = React.useState(null);
    const { data: matterData, setData: setMatterData, post: postMatter, processing: matterProcessing, errors: matterErrors, reset: resetMatter } = useForm({ name: '', code: '' });
    const handleMatterSubmit = (e) => { e.preventDefault(); postMatter(route('matters.store'), { onSuccess: () => resetMatter() }); };
    const [subMatterForm, setSubMatterForm] = React.useState({ matterId: null, name: '', code: '' });
    const { data: subMatterData, setData: setSubMatterData, post: postSubMatter, processing: subMatterProcessing, errors: subMatterErrors, reset: resetSubMatter } = useForm({ name: '', code: '' });
    const handleSubMatterSubmit = (e) => { e.preventDefault(); postSubMatter(route('matters.storeSubMatter', subMatterForm.matterId), { onSuccess: () => { resetSubMatter(); setSubMatterForm({ matterId: null, name: '', code: '' }); } }); };
    const openSubMatterModal = (matterId) => { setSubMatterForm({ matterId, name: '', code: '' }); resetSubMatter(); };

    return (
        <AppLayout title="Matters - Law Practice Management">
            <Head><title>Matters - Law Practice Management</title></Head>
            <div className="page-header"><div><h1 className="page-title">Matters</h1><p className="page-subtitle">Manage practice matters and sub-matters</p></div></div>
            {flash.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="row"><div className="col-12 col-lg-8">
                <div className="card border-light shadow-sm">
                    <div className="card-header"><h2 className="card-title">Add Matter</h2></div>
                    <div className="card-body">
                        <form onSubmit={handleMatterSubmit} className="mb-4 p-3 bg-light rounded">
                            <div className="row g-3">
                                <div className="col-md-6"><label className="form-label-custom">Matter Name <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${matterErrors.name ? 'is-invalid-custom' : ''}`} value={matterData.name} onChange={(e) => setMatterData('name', e.target.value)} placeholder="Enter matter name" required />{matterErrors.name && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {matterErrors.name}</div>}</div>
                                <div className="col-md-6"><label className="form-label-custom">Matter Code <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${matterErrors.code ? 'is-invalid-custom' : ''}`} value={matterData.code} onChange={(e) => setMatterData('code', e.target.value)} placeholder="Enter matter code" required />{matterErrors.code && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {matterErrors.code}</div>}</div>
                            </div>
                            <div className="d-flex gap-2 mt-3"><button type="submit" className="btn-custom btn-custom-primary" disabled={matterProcessing}>{matterProcessing ? <><span className="spinner-border spinner-border-sm me-2"></span>Adding...</> : <><i className="bi bi-check-lg"></i> Add Matter</>}</button></div>
                        </form>
                        <div className="accordion" id="mattersAccordion">
                            {matters.data.map((matter) => (
                                <div key={matter.id} className="accordion-item border-bottom">
                                    <h3 className="accordion-header">
                                        <button className={`accordion-button ${expandedMatter !== matter.id ? 'collapsed' : ''}`} type="button" data-bs-toggle="collapse" data-bs-target={"#matter-" + matter.id} onClick={() => setExpandedMatter(expandedMatter === matter.id ? null : matter.id)}>
                                            <div className="d-flex justify-content-between w-100"><div><strong>{matter.name}</strong><span className="badge bg-primary ms-2">{matter.code.toUpperCase()}</span></div><div className="d-flex gap-1">
                                                <button type="button" className="btn btn-sm btn-outline-primary" onClick={() => openSubMatterModal(matter.id)} data-bs-toggle="modal" data-bs-target="#subMatterModal"><i className="bi bi-plus-lg"></i> Add Sub Matter</button>
                                                <form onSubmit={(e) => { e.preventDefault(); if (confirm('Are you sure you want to delete this matter?')) e.currentTarget.submit(); }} action={route('matters.destroy', matter)} method="POST"><input type="hidden" name="_method" value="DELETE" /><input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} /><button type="submit" className="btn btn-sm btn-outline-danger" title="Delete"><i className="bi bi-trash"></i></button></form>
                                            </div></div>
                                        </button>
                                    </h3>
                                    <div id={"matter-" + matter.id} className={"accordion-collapse collapse " + (expandedMatter === matter.id ? 'show' : '')}>
                                        <div className="accordion-body">
                                            <div className="table-responsive"><table className="table table-sm"><thead><tr><th>Sub Matter Name</th><th>Code</th><th className="text-center">Actions</th></tr></thead><tbody>{matter.subMatters?.map((subMatter) => (
                                                <tr key={subMatter.id}><td>{subMatter.name}</td><td>{subMatter.code.toUpperCase()}</td><td><form onSubmit={(e) => { e.preventDefault(); if (confirm('Are you sure you want to delete this sub matter?')) e.currentTarget.submit(); }} action={route('matters.destroySubMatter', [matter, subMatter])} method="POST"><input type="hidden" name="_method" value="DELETE" /><input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} /><button type="submit" className="table-btn-action delete" title="Delete"><i className="bi bi-trash"></i></button></form></td></tr>
                                            ))}</tbody></table></div>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                        <div className="table-footer-control mt-3">
                            <span className="table-pagination-info">Showing {matters.from} to {matters.to} of {matters.total} entries</span>
                            <nav aria-label="Page navigation"><ul className="pagination mb-0 gap-1">{matters.prev_page_url && <li className="page-item"><a className="page-link border-0" href={matters.prev_page_url}><i className="bi bi-chevron-left"></i></a></li>}{Array.from({ length: matters.last_page }, (_, i) => i + 1).map((page) => <li key={page} className={`page-item ${matters.current_page === page ? 'active' : ''}`}><a className="page-link border-0" href={`${route('matters.index')}?page=${page}`}>{page}</a></li>)}{matters.next_page_url && <li className="page-item"><a className="page-link border-0" href={matters.next_page_url}><i className="bi bi-chevron-right"></i></a></li>}</ul></nav>
                        </div>
                    </div>
                </div>
            </div></div>
            <div className="modal fade" id="subMatterModal" tabIndex="-1" aria-hidden="true">
                <div className="modal-dialog"><div className="modal-content">
                    <div className="modal-header"><h5 className="modal-title">Add Sub Matter</h5><button type="button" className="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <form onSubmit={handleSubMatterSubmit}>
                        <div className="modal-body"><input type="hidden" name="matter_id" value={subMatterForm.matterId} /><div className="row g-3">
                            <div className="col-md-6"><label className="form-label-custom">Sub Matter Name <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${subMatterErrors.name ? 'is-invalid-custom' : ''}`} value={subMatterData.name} onChange={(e) => setSubMatterData('name', e.target.value)} placeholder="Enter sub matter name" required />{subMatterErrors.name && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {subMatterErrors.name}</div>}</div>
                            <div className="col-md-6"><label className="form-label-custom">Sub Matter Code <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${subMatterErrors.code ? 'is-invalid-custom' : ''}`} value={subMatterData.code} onChange={(e) => setSubMatterData('code', e.target.value)} placeholder="Enter sub matter code" required />{subMatterErrors.code && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {subMatterErrors.code}</div>}</div>
                        </div></div>
                        <div className="modal-footer"><button type="button" className="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" className="btn btn-primary" disabled={subMatterProcessing}>{subMatterProcessing ? 'Adding...' : 'Add Sub Matter'}</button></div>
                    </form>
                </div></div>
            </div>
        </AppLayout>
    );
}
