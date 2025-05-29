document.addEventListener('DOMContentLoaded', function() {
    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.style.backgroundColor = type === 'success' ? '#4CAF50' : '#f44336';
        toast.textContent = message;
        document.body.appendChild(toast);
        toast.style.display = 'block';
        
        setTimeout(() => {
            toast.style.display = 'none';
            document.body.removeChild(toast);
        }, 3000);
    }

    // Confirmation modal
    function showConfirmModal(message, onConfirm) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <p>${message}</p>
                <div class="modal-buttons">
                    <button class="modal-button confirm-button">Xác nhận</button>
                    <button class="modal-button cancel-button">Hủy</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        modal.style.display = 'block';

        const confirmBtn = modal.querySelector('.confirm-button');
        const cancelBtn = modal.querySelector('.cancel-button');

        confirmBtn.addEventListener('click', () => {
            onConfirm();
            modal.style.display = 'none';
            document.body.removeChild(modal);
        });

        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            document.body.removeChild(modal);
        });
    }

    // Handle delete user
    function handleDelete(event, userId) {
        event.preventDefault();
        
        showConfirmModal('Bạn có chắc chắn muốn xóa người dùng này?', () => {
            fetch(`modules/quanlyuser/xuly.php?idadmin=${userId}`, {
                method: 'GET'
            })
            .then(response => response.text())
            .then(data => {
                const row = event.target.closest('tr');
                row.style.animation = 'fadeOut 0.3s ease-in-out';
                setTimeout(() => {
                    row.remove();
                    showToast('Đã xóa người dùng thành công');
                }, 300);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi xóa người dùng', 'error');
            });
        });
    }

    // Add click event listeners to delete buttons
    document.querySelectorAll('.delete-button').forEach(button => {
        const userId = button.getAttribute('data-id');
        button.addEventListener('click', (e) => handleDelete(e, userId));
    });

    // Add animation styles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    `;
    document.head.appendChild(style);
});