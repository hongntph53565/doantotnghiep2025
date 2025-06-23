document.addEventListener("DOMContentLoaded", function () {
    const cinemaSelect = document.getElementById("cinema_id");
    const roomSelect = document.getElementById("room_id");

    function filterRooms() {
        const selectedCinema = cinemaSelect.value;
        const selectedRoom = roomSelect.value;

        Array.from(roomSelect.options).forEach((option) => {
            const cinemaId = option.getAttribute("data-cinema");

            if (!cinemaId) {
                option.style.display = "";
                return;
            }

            if (cinemaId === selectedCinema) {
                option.style.display = "";
            } else {
                option.style.display = "none";

                if (option.value === selectedRoom) {
                    roomSelect.value = "";
                }
            }
        });
    }

    cinemaSelect.addEventListener("change", filterRooms);

    filterRooms();
});
