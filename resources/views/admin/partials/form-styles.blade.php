<style>
/* â”€â”€â”€ Shared Admin Form Styles â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes popIn {
    0%   { opacity: 0; transform: scale(0.5); }
    70%  { transform: scale(1.1); }
    100% { opacity: 1; transform: scale(1); }
}
.fade-up {
    animation: fadeUp 0.6s ease forwards;
    opacity: 0;
}
.fade-up-1 { animation-delay: 0.1s; }
.fade-up-2 { animation-delay: 0.2s; }
.fade-up-3 { animation-delay: 0.3s; }
.fade-up-4 { animation-delay: 0.4s; }
.fade-up-5 { animation-delay: 0.5s; }
.pop-in { animation: popIn 0.4s ease forwards; }

/* â”€â”€â”€ Admin Form Page Layout â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.admin-form-page {
    background: linear-gradient(180deg, #F5F0EB 0%, #EDE8E0 100%);
    min-height: 100vh;
    padding: 30px 24px;
    margin: -24px -28px;
}
.admin-form-container {
    max-width: 1000px;
    margin: 0 auto;
}

/* â”€â”€â”€ Form Card â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-card {
    background: #FFFFFF;
    border: 1px solid #E0E6E2;
    border-radius: 16px;
    padding: 32px 36px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.02);
    margin-bottom: 24px;
}
.form-card-header {
    border-bottom: 1px solid #E8ECEA;
    padding-bottom: 16px;
    margin-bottom: 24px;
}
.form-card-header h3 {
    font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
    font-size: 1.15rem;
    font-weight: 700;
    color: #0D2618;
    margin: 0;
}

/* â”€â”€â”€ Form Grid â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px 32px;
}
.form-grid .full-col { grid-column: 1 / -1; }
.form-grid .col-left { grid-column: 1 / 2; }
.form-grid .col-right { grid-column: 2 / 3; }

/* â”€â”€â”€ Form Controls â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-group label {
    font-family: 'Inter', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    color: #0D2618;
}
.form-group label .required {
    color: #C62828;
    margin-left: 2px;
}
.form-group label .hint {
    font-weight: 400;
    color: #8A9A92;
    font-size: 0.7rem;
}

.form-control {
    width: 100%;
    border: 1px solid #E0E6E2;
    border-radius: 10px;
    padding: 11px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    color: #0D2618;
    background: #FFFFFF;
    transition: all 0.3s ease;
    outline: none;
}
.form-control:focus {
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.1);
}
.form-control::placeholder {
    color: #8A9A92;
    font-weight: 400;
}
.form-control.font-bold {
    font-weight: 700;
}
textarea.form-control {
    resize: vertical;
    min-height: 80px;
    line-height: 1.6;
}

/* Select styling */
select.form-control {
    appearance: auto;
    cursor: pointer;
}

/* â”€â”€â”€ Toggle / Checkbox â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.toggle-group {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 4px 0;
}
.toggle-group input[type="checkbox"] {
    width: 20px;
    height: 20px;
    border: 2px solid #D4DCD6;
    border-radius: 4px;
    cursor: pointer;
    accent-color: #0D2618;
    transition: all 0.2s ease;
}
.toggle-group input[type="checkbox"]:checked {
    border-color: #0D2618;
}
.toggle-group label {
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    font-weight: 600;
    color: #0D2618;
    cursor: pointer;
}

.discount-fields {
    transition: all 0.3s ease;
}
.discount-fields.disabled {
    opacity: 0.3;
    pointer-events: none;
}

/* â”€â”€â”€ Upload Area â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.upload-area {
    border: 2px dashed #D4DCD6;
    border-radius: 12px;
    padding: 40px 20px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #FAFAFA;
}
.upload-area:hover {
    border-color: #0D2618;
    background: rgba(13, 38, 24, 0.02);
}
.upload-area .upload-icon {
    font-size: 2.5rem;
    color: #8A9A92;
    margin-bottom: 8px;
}
.upload-area .upload-text {
    font-family: 'Inter', sans-serif;
    color: #6A7A72;
    font-size: 0.9rem;
    font-weight: 500;
    margin: 0 0 4px;
}
.upload-area .upload-hint {
    font-size: 0.7rem;
    color: #8A9A92;
    margin: 0;
}

/* Preview images */
.upload-preview {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 12px;
}
.preview-item {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    border: 2px solid #E0E6E2;
    overflow: hidden;
    position: relative;
    background: #F5F0EB;
    flex-shrink: 0;
}
.preview-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.preview-item .remove-img {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 22px;
    height: 22px;
    background: #C62828;
    color: #FFFFFF;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 0.7rem;
    line-height: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    transition: transform 0.2s ease;
}
.preview-item .remove-img:hover {
    transform: scale(1.15);
}
.preview-item .badge-main {
    position: absolute;
    bottom: 4px;
    left: 4px;
    background: #0D2618;
    color: #FFFFFF;
    font-size: 0.5rem;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
    text-transform: uppercase;
}

/* â”€â”€â”€ Benefits / Chips â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.benefits-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}
.benefit-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(13, 38, 24, 0.08);
    border: 1px solid rgba(13, 38, 24, 0.15);
    border-radius: 50px;
    padding: 4px 12px 4px 16px;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    color: #0D2618;
    animation: popIn 0.3s ease forwards;
}
.benefit-chip .remove {
    cursor: pointer;
    color: #8A9A92;
    transition: color 0.3s ease;
    background: none;
    border: none;
    font-size: 1rem;
    line-height: 1;
    padding: 0;
}
.benefit-chip .remove:hover {
    color: #C62828;
}
.benefit-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-top: 12px;
    padding: 10px 20px;
    border-radius: 50px;
    border: 2px dashed #D4DCD6;
    background: transparent;
    color: #6A7A72;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}
.benefit-add-btn:hover {
    border-color: #0D2618;
    color: #0D2618;
    background: rgba(13, 38, 24, 0.03);
}

/* â”€â”€â”€ Existing photos grid (edit mode) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.existing-photos {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
    gap: 12px;
}
.existing-photo-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: 8px;
    overflow: hidden;
    border: 2px solid #E0E6E2;
    background: #F5F0EB;
}
.existing-photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.existing-photo-item .badge-primary {
    position: absolute;
    top: 4px;
    left: 4px;
    background: #0D2618;
    color: #FFFFFF;
    font-size: 0.5rem;
    font-weight: 700;
    padding: 1px 6px;
    border-radius: 4px;
    text-transform: uppercase;
}
.existing-photo-item .delete-btn {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 22px;
    height: 22px;
    background: #C62828;
    color: #FFFFFF;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    font-size: 0.65rem;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    z-index: 2;
    transition: opacity 0.2s ease;
}
.existing-photo-item:hover .delete-btn {
    opacity: 1;
}
.existing-photo-item.marked-delete {
    opacity: 0.3;
    pointer-events: none;
}
.existing-photo-item.marked-delete::after {
    content: 'Dihapus';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: #C62828;
    color: #fff;
    font-size: 0.5rem;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
    z-index: 3;
}

/* â”€â”€â”€ Form Actions â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-actions {
    display: flex;
    gap: 12px;
    margin-top: 28px;
    padding-top: 24px;
    border-top: 1px solid #E8ECEA;
}
.btn-save {
    background: linear-gradient(135deg, #0D2618, #0D2618);
    color: #FFFFFF;
    padding: 14px 40px;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
}
.btn-save:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 30px rgba(13, 38, 24, 0.2);
    color: #FFFFFF;
    text-decoration: none;
}
.btn-cancel {
    background: transparent;
    color: #6A7A72;
    padding: 14px 32px;
    border-radius: 50px;
    border: 2px solid #D4DCD6;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}
.btn-cancel:hover {
    border-color: #C62828;
    color: #C62828;
    transform: scale(1.02);
    text-decoration: none;
}

/* â”€â”€â”€ Error Box â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-error {
    background: rgba(198, 40, 40, 0.06);
    border: 1px solid rgba(198, 40, 40, 0.2);
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
}
.form-error ul {
    margin: 0;
    padding-left: 20px;
    color: #C62828;
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    list-style: disc;
}
.form-error ul li { margin-bottom: 4px; }
.form-error ul li:last-child { margin-bottom: 0; }

/* â”€â”€â”€ Warning (discount etc.) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
.form-warning {
    margin-top: 8px;
    font-size: 0.75rem;
    font-weight: 500;
    color: #C62828;
    display: none;
}
.form-warning.show { display: block; }

/* â”€â”€â”€ Responsive â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
@media (max-width: 768px) {
    .admin-form-page {
        margin: -24px -16px;
        padding: 16px;
    }
    .admin-form-container {
        max-width: 100%;
    }
    .form-card {
        padding: 20px 16px;
    }
    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    .form-grid .full-col,
    .form-grid .col-left,
    .form-grid .col-right {
        grid-column: 1;
    }
    .form-actions {
        flex-direction: column;
        gap: 10px;
    }
    .btn-save,
    .btn-cancel {
        width: 100%;
        justify-content: center;
        padding: 14px 20px;
    }
    .upload-area {
        padding: 24px 16px;
    }
    .existing-photos {
        grid-template-columns: repeat(auto-fill, minmax(70px, 1fr));
        gap: 8px;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .admin-form-page {
        margin: -24px -20px;
        padding: 24px 20px;
    }
    .form-card {
        padding: 28px 24px;
    }
}
</style>
