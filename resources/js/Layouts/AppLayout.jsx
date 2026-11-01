import React from 'react';
import { Head } from '@inertiajs/react';

export default function AppLayout({ children, title = 'Law Practice Management' }) {
    return (
        <>
            <Head>
                <title>{title}</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <link rel="icon" type="image/png" href="/spark-admin/assets/images/favicon.ico" />
                
                <link rel="stylesheet" href="/spark-admin/assets/libs/bootstrap/css/bootstrap.min.css" />
                <link rel="stylesheet" href="/spark-admin/assets/libs/bootstrap-icons/bootstrap-icons.css" />
                <link rel="stylesheet" href="/spark-admin/assets/libs/apexcharts/apexcharts.css" />
                <link rel="stylesheet" href="/spark-admin/assets/libs/flatpickr/flatpickr.min.css" />
                <link rel="stylesheet" href="/spark-admin/assets/css/main.css" />
            </Head>
            
            <div class="sidebar-wrapper" id="sidebar">
                <a href="/law-cases" class="sidebar-brand">
                    <i class="bi bi-asterisk"></i>
                    <span>Law Practice</span>
                </a>

                <div class="flex-grow-1 overflow-y-auto">
                    <div class="sidebar-menu-section">
                        <div class="sidebar-menu-title">Menu</div>
                        <ul class="sidebar-menu-list">
                            <li class="sidebar-menu-item">
                                <a href="/law-cases" class="sidebar-menu-link" id="menu-cases" title="Cases">
                                    <i class="bi bi-folder"></i>
                                    <span>Cases</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="sidebar-menu-section">
                        <div class="sidebar-menu-title">Components</div>
                        <ul class="sidebar-menu-list">
                            <li class="sidebar-menu-item">
                                <a href="/law-cases" class="sidebar-menu-link" id="menu-basictables" title="Case List">
                                    <i class="bi bi-table"></i>
                                    <span>Case List</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="sidebar-profile">
                    <img src="/spark-admin/assets/images/avatar.png" alt="Administrator" class="sidebar-profile-img"
                        onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'" />
                    <div class="sidebar-profile-info">
                        <div class="sidebar-profile-name">Administrator</div>
                        <div class="sidebar-profile-email">admin@email.com</div>
                    </div>
                </div>
            </div>

            <div class="main-wrapper">
                <header class="navbar-custom">
                    <div class="navbar-left">
                        <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
                            id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
                            <i class="bi bi-chevron-bar-left"></i>
                        </button>
                        <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
                            <i class="bi bi-list"></i>
                        </button>

                        <div class="dropdown ms-2">
                            <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="quick-actions-dropdown">
                                <i class="bi bi-plus-lg"></i>
                                <span>Create</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
                                <li class="dropdown-header">Quick Actions</li>
                                <li><a class="dropdown-item" href="/law-cases/create"><i class="bi bi-file-earmark-plus"></i> New Case</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person-plus"></i> New Client</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> System Settings</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="navbar-search-wrapper">
                        <input type="text" class="navbar-search-input" placeholder="Search cases..." id="main-search" />
                        <button class="navbar-search-btn" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="navbar-actions">
                        <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                        <div class="dropdown">
                            <button class="navbar-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
                                <i class="bi bi-bell"></i>
                                <span class="navbar-action-badge"></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0"
                                aria-labelledby="btn-notifications">
                                <div class="notification-header">
                                    <h6 class="notification-title">Notifications</h6>
                                    <button class="btn-clear-all" type="button">Mark all read</button>
                                </div>
                                <div class="notification-list">
                                    <a href="#" class="notification-item">
                                        <div class="notification-icon bg-success text-white">
                                            <i class="bi bi-wallet2"></i>
                                        </div>
                                        <div class="notification-content">
                                            <p class="notification-text">System ready</p>
                                            <span class="notification-time">Just now</span>
                                        </div>
                                    </a>
                                </div>
                                <a href="#" class="notification-footer">View All</a>
                            </div>
                        </div>

                        <div class="dropdown ms-2">
                            <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" id="profile-dropdown">
                                <img src="/spark-admin/assets/images/avatar.png" alt="Profile" class="navbar-profile-img" />
                                <span class="navbar-profile-name d-none d-md-inline">Administrator</span>
                                <i class="bi bi-chevron-down navbar-profile-caret"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
                                <li class="dropdown-header">Welcome!</li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Account</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider" />
                                </li>
                                <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </header>

                <main>
                    {children}
                </main>

                <footer class="footer-custom">
                    <div class="footer-left">
                        <span class="footer-logo">
                            <i class="bi bi-asterisk"></i> Law Practice
                        </span>
                        <span class="footer-separator">|</span>
                        <span class="footer-copy">&copy; {new Date().getFullYear()} Law Practice Management System</span>
                    </div>
                    <div class="footer-right">
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Overview</a></li>
                            <li><a href="#" class="footer-link">Help</a></li>
                            <li><a href="#" class="footer-link">Status <span class="status-dot"></span></a></li>
                        </ul>
                    </div>
                </footer>
            </div>

            <script src="/spark-admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="/spark-admin/assets/libs/apexcharts/apexcharts.min.js"></script>
            <script src="/spark-admin/assets/libs/flatpickr/flatpickr.min.js"></script>
            <script src="/spark-admin/assets/js/dashboard.js"></script>
        </>
    );
}
