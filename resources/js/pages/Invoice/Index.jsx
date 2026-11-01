import React from 'react';
import { useForm, Head, usePage } from '@inertiajs/react';
import AppLayout from '../../Layouts/AppLayout';

export default function InvoiceIndex({ invoices }) {
    const { flash } = usePage().props;
    const [services, setServices] = React.useState([{ service: '', amount: 0 }]);
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '', phoneNumber: '', address: '', services: [{ service: '', amount: 0 }],
    });

    const addService = () => { const newServices = [...services, { service: '', amount: 0 }]; setServices(newServices); setData('services', newServices); };
    const removeService = (index) => { const newServices = services.filter((_, i) => i !== index); setServices(newServices); setData('services', newServices); };
    const updateService = (index, field, value) => { const newServices = [...services]; newServices[index] = { ...newServices[index], [field]: value }; setServices(newServices); setData('services', newServices); };
    const handleSubmit = (e) => { e.preventDefault(); post(route('invoice.store'), { onSuccess: () => { reset(); setServices([{ service: '', amount: 0 }]); } }); };

    return (
        <AppLayout title="Invoice - Law Practice Management">
            <Head><title>Invoice - Law Practice Management</title></Head>
            <div className="page-header"><div><h1 className="page-title">Invoice</h1><p className="page-subtitle">Create and manage invoices</p></div></div>
            {flash.success && <div className="alert alert-success alert-dismissible fade show mb-4" role="alert">{flash.success}<button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>}
            <div className="row">
                <div className="col-12 col-lg-8">
                    <div className="card border-light shadow-sm">
                        <div className="card-header"><h2 className="card-title">Create Invoice</h2></div>
                        <div className="card-body">
                            <form onSubmit={handleSubmit}>
                                <div className="row g-3 mb-4">
                                    <div className="col-md-6"><label className="form-label-custom">Client Name <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${errors.name ? 'is-invalid-custom' : ''}`} value={data.name} onChange={(e) => setData('name', e.target.value)} placeholder="Client name" required />{errors.name && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.name}</div>}</div>
                                    <div className="col-md-6"><label className="form-label-custom">Phone Number <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${errors.phoneNumber ? 'is-invalid-custom' : ''}`} value={data.phoneNumber} onChange={(e) => setData('phoneNumber', e.target.value)} placeholder="Phone number" required />{errors.phoneNumber && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.phoneNumber}</div>}</div>
                                    <div className="col-12"><label className="form-label-custom">Address <span className="text-danger">*</span></label><textarea className={`form-control-custom ${errors.address ? 'is-invalid-custom' : ''}`} rows="2" value={data.address} onChange={(e) => setData('address', e.target.value)} placeholder="Client address" required />{errors.address && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.address}</div>}</div>
                                </div>
                                <h5 className="mb-3">Services</h5>
                                {services.map((srv, index) => (
                                    <div key={index} className="row g-3 mb-3 p-3 border rounded">
                                        <div className="col-md-5"><label className="form-label-custom">Service <span className="text-danger">*</span></label><input type="text" className={`form-control-custom ${errors.services && errors.services[index] && errors.services[index].service ? 'is-invalid-custom' : ''}`} value={srv.service} onChange={(e) => updateService(index, 'service', e.target.value)} placeholder="Service description" required />{errors.services && errors.services[index] && errors.services[index].service && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.services[index].service}</div>}</div>
                                        <div className="col-md-5"><label className="form-label-custom">Amount <span className="text-danger">*</span></label><input type="number" step="0.01" min="0" className={`form-control-custom ${errors.services && errors.services[index] && errors.services[index].amount ? 'is-invalid-custom' : ''}`} value={srv.amount} onChange={(e) => updateService(index, 'amount', parseFloat(e.target.value) || 0)} placeholder="0.00" required />{errors.services && errors.services[index] && errors.services[index].amount && <div className="form-feedback-custom invalid-custom"><i className="bi bi-exclamation-circle-fill"></i> {errors.services[index].amount}</div>}</div>
                                        <div className="col-md-2 d-flex align-items-end"><button type="button" className="btn btn-outline-danger w-100" onClick={() => removeService(index)} disabled={services.length <= 1}><i className="bi bi-trash"></i></button></div>
                                    </div>
                                ))}
                                <button type="button" className="btn btn-outline-primary mb-4" onClick={addService}><i className="bi bi-plus-lg"></i> Add Service</button>
                                <div className="d-flex gap-2"><button type="submit" className="btn-custom btn-custom-primary" disabled={processing}>{processing ? <><span className="spinner-border spinner-border-sm me-2"></span>Creating...</> : <><i className="bi bi-check-lg"></i> Create Invoice</>}</button></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div className="col-12 col-lg-4">
                    <div className="card border-light shadow-sm">
                        <div className="card-header"><h2 className="card-title">Recent Invoices</h2></div>
                        <div className="card-body">
                            <div className="table-responsive"><table className="table table-sm"><thead><tr><th>Client</th><th>Total</th><th>Date</th></tr></thead><tbody>{invoices.data.map((inv) => (<tr key={inv.id}><td>{inv.name}</td><td>${inv.services?.reduce((sum, s) => sum + (s.amount || 0), 0).toFixed(2) || '0.00'}</td><td>{new Date(inv.created_at).toLocaleDateString()}</td></tr>))}</tbody></table></div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
