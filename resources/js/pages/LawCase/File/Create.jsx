import React from 'react';
import { useForm, Head, Link } from '@inertiajs/react';
import AppLayout from '../../../Layouts/AppLayout';

export default function FileCreate({ lawCase }) {
    const { data, setData, post, processing, errors } = useForm({
        filename: '',
        file: null,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route('law-cases.files.store', lawCase), {
            forceFormData: true,
        });
    };

    const handleFileChange = (e) => {
        setData('file', e.target.files[0]);
        setData('filename', e.target.files[0]?.name || '');
    };

    return (
        <AppLayout title={`Upload File - Case #${lawCase.id} - Law Practice Management`}>
            <Head>
                <title>Upload File - Law Practice Management</title>
            </Head>

            <div class="page-header">
                <div>
                    <h1 class="page-title">Upload File</h1>
                    <p class="page-subtitle">Case: {lawCase.case_plaintiff} v. {lawCase.case_defendant}</p>
                </div>
            </div>

            <Link href={`/law-cases/${lawCase.id}/files`} class="btn-custom btn-custom-secondary mb-3">
                <i class="bi bi-arrow-left"></i> Back to Files
            </Link>

            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card border-light shadow-sm">
                        <div class="card-header">
                            <h2 class="card-title">File Upload</h2>
                        </div>
                        <div class="card-body">
                            <form onSubmit={handleSubmit} encType="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label-custom">File Name <span class="text-danger">*</span></label>
                                        <input
                                            type="text"
                                            className={`form-control-custom ${errors.filename ? 'is-invalid-custom' : ''}`}
                                            value={data.filename}
                                            onChange={(e) => setData('filename', e.target.value)}
                                            placeholder="File name"
                                            required
                                        />
                                        {errors.filename && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.filename}
                                            </div>
                                        )}
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-custom">File <span class="text-danger">*</span></label>
                                        <input
                                            type="file"
                                            className={`form-control-custom ${errors.file ? 'is-invalid-custom' : ''}`}
                                            onChange={handleFileChange}
                                            required
                                        />
                                        {errors.file && (
                                            <div class="form-feedback-custom invalid-custom">
                                                <i class="bi bi-exclamation-circle-fill"></i> {errors.file}
                                            </div>
                                        )}
                                        <div class="form-text">Max file size: 10MB</div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-4">
                                    <button type="submit" class="btn-custom btn-custom-primary" disabled={processing}>
                                        {processing ? (
                                            <><span className="spinner-border spinner-border-sm me-2"></span>Uploading...</>
                                        ) : (
                                            <><i className="bi bi-upload"></i> Upload File</>
                                        )}
                                    </button>
                                    <Link href={`/law-cases/${lawCase.id}/files`} class="btn-custom btn-custom-secondary">
                                        <i class="bi bi-x-lg"></i> Cancel
                                    </Link>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
