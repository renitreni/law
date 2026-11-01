import React from 'react';

export default function Welcome({ message }) {
    return (
        <div className="container py-5">
            <div className="row justify-content-center">
                <div className="col-md-8">
                    <div className="card">
                        <div className="card-body text-center py-5">
                            <i className="bi bi-check-circle-fill text-success" style={{fontSize: '4rem'}}></i>
                            <h2 className="mt-3">Inertia + React Works!</h2>
                            <p className="text-muted mt-3">{message}</p>
                            <hr className="my-4" />
                            <p className="text-muted small">
                                Ready to build the Law Practice Management system with React, Inertia.js, and Laravel.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}