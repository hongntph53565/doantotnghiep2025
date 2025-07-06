<div class="container mb-5">
        <div class="row">
            {{-- Lịch chiếu bên trái --}}
            <div class="col-md-9">
                <div class="schedule-box">
                    <h6 class="fw-bold">LumiStar The Garden</h6>
                    <p class="text-muted">Tầng 4 & 5, TTTM The Garden, khu đô thị The Manor, đường Mễ Trì, phường Mỹ Đình 1,
                        quận Nam Từ Liêm, Hà Nội</p>
                    <div class="d-flex flex-wrap">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="me-3 mb-3 text-center">
                                <div class="showtime-btn">09:20</div>
                                <div class="tag">Phụ đề</div>
                                <div class="tag green">2D</div>
                            </div>
                        @endfor
                    </div>

                    <h6 class="fw-bold mt-4">LumiStar Phạm Ngọc Thạch</h6>
                    <p class="text-muted">Tầng 8, TTTM Vincom, số 2 Phạm Ngọc Thạch, Đống Đa, Hà Nội</p>
                    <div class="d-flex flex-wrap">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="me-3 mb-3 text-center">
                                <div class="showtime-btn" onclick="goToStep(1)">09:20</div>
                                <div class="tag">Lồng tiếng</div>
                                <div class="tag green">2D</div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Datepicker bên phải --}}
            <div class="col-md-3 mt-3 mt-md-0">
                <div class="datepicker-wrapper">
                    <div class="datepicker">
                        <div class="datepicker-inner">
                            <div class="datepicker-header">
                                <div class="arrow" onclick="changeMonth(-1)">&#x276E;</div>
                                <div class="month-labels">
                                    <div class="month-text" id="month-label"></div>
                                    <div id="month-picker" class="month-picker hidden"></div>
                                    <div id="year-picker" class="year-picker hidden"></div>
                                    <div class="year-text" id="year-label"></div>
                                </div>
                                <div class="arrow" onclick="changeMonth(1)">&#x276F;</div>
                            </div>
                            <div class="day-names">
                                <div class="day-name">2</div>
                                <div class="day-name">3</div>
                                <div class="day-name">4</div>
                                <div class="day-name">5</div>
                                <div class="day-name">6</div>
                                <div class="day-name">7</div>
                                <div class="day-name">CN</div>
                            </div>
                            <div class="days" id="datepicker-days"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>