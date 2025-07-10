    document.addEventListener('DOMContentLoaded', function () {
        const reviewModal = document.getElementById('reviewDetailModal');

        reviewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            const customer = button.getAttribute('data-customer');
            const movie = button.getAttribute('data-movie');
            const date = button.getAttribute('data-date');
            const stars = button.getAttribute('data-stars');
            const content = button.getAttribute('data-content');

            // Gán dữ liệu vào modal
            reviewModal.querySelector('#reviewCustomer').textContent = customer;
            reviewModal.querySelector('#reviewMovie').textContent = movie;
            reviewModal.querySelector('#reviewDate').textContent = date;

            // Sao: chuyển số thành icon sao
            reviewModal.querySelector('#reviewStars').innerHTML = '★'.repeat(stars) + '☆'.repeat(5 - stars);

            reviewModal.querySelector('#reviewContent').textContent = content;
        });
    });