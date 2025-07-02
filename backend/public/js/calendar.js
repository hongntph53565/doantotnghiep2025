      const daysContainer = document.getElementById("datepicker-days");
      const today = new Date();
      let currentMonth = today.getMonth();
      let currentYear = today.getFullYear();
      let selectedDate = today;

      const monthNames = [
        "THÁNG 1", "THÁNG 2", "THÁNG 3", "THÁNG 4", "THÁNG 5", "THÁNG 6",
        "THÁNG 7", "THÁNG 8", "THÁNG 9", "THÁNG 10", "THÁNG 11", "THÁNG 12"
      ];

      function renderCalendar(month, year) {
        const now = new Date();
        const isCurrentMonth = month === now.getMonth() && year === now.getFullYear();

        document.getElementById("month-label").textContent = monthNames[month];
        document.getElementById("year-label").textContent = year;
        daysContainer.innerHTML = "";

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const prevMonthDays = new Date(year, month, 0).getDate();
        const startDay = (firstDay + 6) % 7;

        for (let i = startDay - 1; i >= 0; i--) {
          daysContainer.appendChild(createDayElement(prevMonthDays - i, true));
        }

        let hasSelected = false;
        for (let day = 1; day <= daysInMonth; day++) {
          const thisDate = new Date(year, month, day);
          const isPast =
            year < now.getFullYear() ||
            (year === now.getFullYear() && month < now.getMonth()) ||
            (year === now.getFullYear() && month === now.getMonth() && day < now.getDate());

          const dayEl = createDayElement(day, isPast);
          if (!isPast && isCurrentMonth) {
            dayEl.addEventListener("click", () => {
              selectedDate = thisDate;
              renderCalendar(month, year);
              console.log("Ngày đã chọn:", selectedDate.toLocaleDateString("vi-VN"));
            });
          }

          if (
            isCurrentMonth &&
            day === now.getDate() &&
            !isPast &&
            !hasSelected
          ) {
            dayEl.classList.add("today", "selected");
            selectedDate = thisDate;
            hasSelected = true;
          }

          daysContainer.appendChild(dayEl);
        }

        const remaining = (7 - (daysContainer.children.length % 7)) % 7;
        for (let i = 1; i <= remaining; i++) {
          daysContainer.appendChild(createDayElement(i, true));
        }
      }

      function createDayElement(day, inactive = false) {
        const el = document.createElement("div");
        el.className = "day" + (inactive ? " inactive" : "");
        el.textContent = day;
        return el;
      }

      function changeMonth(offset) {
        currentMonth += offset;
        if (currentMonth < 0) {
          currentMonth = 11;
          currentYear--;
        } else if (currentMonth > 11) {
          currentMonth = 0;
          currentYear++;
        }
        renderCalendar(currentMonth, currentYear);
      }

      const monthPicker = document.getElementById("month-picker");
      const yearPicker = document.getElementById("year-picker");
      const monthLabel = document.getElementById("month-label");
      const yearLabel = document.getElementById("year-label");

      function renderMonthPicker(year) {
        monthPicker.innerHTML = "";
        const now = new Date();

        for (let i = 0; i < 12; i++) {
          const btn = document.createElement("div");
          btn.className = "month-option";
          btn.textContent = "Tháng " + (i + 1);

          const isPast = year < now.getFullYear() || (year === now.getFullYear() && i < now.getMonth());

          if (isPast) {
            btn.classList.add("disabled");
          } else {
            btn.addEventListener("click", () => {
              currentMonth = i;
              selectedDate = new Date(year, i, 1);
              renderCalendar(currentMonth, currentYear);
              monthPicker.classList.add("hidden");
            });
          }

          if (i === currentMonth) {
            btn.classList.add("active");
          }

          monthPicker.appendChild(btn);
        }
      }

      function renderYearPicker() {
        yearPicker.innerHTML = "";
        const now = new Date();
        const startYear = now.getFullYear();
        const endYear = startYear + 10;

        for (let y = startYear; y <= endYear; y++) {
          const btn = document.createElement("div");
          btn.className = "year-option";
          btn.textContent = y;

          btn.addEventListener("click", () => {
            currentYear = y;
            selectedDate = new Date(currentYear, currentMonth, 1);
            renderCalendar(currentMonth, currentYear);
            yearPicker.classList.add("hidden");
          });

          if (y === currentYear) {
            btn.classList.add("active");
          }

          yearPicker.appendChild(btn);
        }
      }

      // Sự kiện nhấn vào tháng
      monthLabel.addEventListener("click", () => {
        if (monthPicker.classList.contains("hidden")) {
          renderMonthPicker(currentYear);
          monthPicker.classList.remove("hidden");
          yearPicker.classList.add("hidden");
        } else {
          monthPicker.classList.add("hidden");
        }
      });

      // Sự kiện nhấn vào năm
      yearLabel.addEventListener("click", () => {
        if (yearPicker.classList.contains("hidden")) {
          renderYearPicker();
          yearPicker.classList.remove("hidden");
          monthPicker.classList.add("hidden");
        } else {
          yearPicker.classList.add("hidden");
        }
      });

      // Ẩn picker nếu click ra ngoài
      document.addEventListener("click", (e) => {
        if (!monthPicker.contains(e.target) && !monthLabel.contains(e.target)) {
          monthPicker.classList.add("hidden");
        }
        if (!yearPicker.contains(e.target) && !yearLabel.contains(e.target)) {
          yearPicker.classList.add("hidden");
        }
      });

      renderCalendar(currentMonth, currentYear);

      