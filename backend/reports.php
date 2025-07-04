<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/header.css">
    <link rel="stylesheet" href="../frontend/reports.css">
</head>
<body>
    <!-- Header is included from header.php -->

    <!-- Main Content -->
    <main class="main-content">
        <div class="dashboard-container loading">
            <h1 class="dashboard-title">
                <i class="fas fa-chart-bar"></i> Reports Dashboard
            </h1>
            <p class="dashboard-subtitle">
                Access comprehensive reports and analytics for your business
            </p>

            <div class="reports-grid">
                <a href="report_invoice.php" class="report-card">
                    <i class="fas fa-file-invoice report-icon"></i>
                    <h3 class="report-title">Invoice Reports</h3>
                    <p class="report-description">
                        View and analyze invoice data, payment status, and revenue trends
                    </p>
                </a>

                <a href="report_items.php" class="report-card">
                    <i class="fas fa-box report-icon"></i>
                    <h3 class="report-title">Item Reports</h3>
                    <p class="report-description">
                        Track inventory levels, popular items, and stock movements
                    </p>
                </a>

                <a href="report_invoice_items.php" class="report-card">
                    <i class="fas fa-clipboard-list report-icon"></i>
                    <h3 class="report-title">Item Invoices Report</h3>
                    <p class="report-description">
                        Detailed breakdown of items within invoices and billing analysis
                    </p>
                </a>
            </div>
        </div>
    </main>

    <script>
        // Add smooth scrolling and loading effects
        document.addEventListener('DOMContentLoaded', () => {
            // Remove loading class to trigger animations
            setTimeout(() => {
                document.querySelector('.loading').classList.remove('loading');
            }, 100);

            // Add click effects to report cards
            const reportCards = document.querySelectorAll('.report-card');
            reportCards.forEach(card => {
                card.addEventListener('click', (e) => {
                    // Add ripple effect
                    const ripple = document.createElement('span');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255, 255, 255, 0.6);
                        pointer-events: none;
                        transform: scale(0);
                        animation: ripple 0.6s linear;
                        left: ${e.offsetX}px;
                        top: ${e.offsetY}px;
                        width: 20px;
                        height: 20px;
                        margin-left: -10px;
                        margin-top: -10px;
                    `;
                    
                    card.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
        });

        // Add ripple animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>