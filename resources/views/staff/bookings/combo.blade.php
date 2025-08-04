@php
    use App\Models\Food;

    $foods = collect();
    $groupedFoods = collect();

    if ($showtime && $showtime->room) {
        $cinemaId = $showtime->room->cinema_id;

        // Lấy các món ăn thuộc rạp chiếu tương ứng
        $foods = Food::where('cinema_id', $cinemaId)
            ->where('status', 'active')
            ->get();

        // Gộp theo loại nếu có cột category
        $groupedFoods = $foods->groupBy(function ($food) {
            return ucfirst($food->category); // Ví dụ: Combo, Drink, Snack
        });
    }
@endphp

<div class="container mb-5">
    <div class="container-combo">
            <div class="left-box">
                <div class="tag-button">Food & Drink</div>
                <hr>
                @foreach ($foods as $food)
                <div class="combo-item" data-id="{{ $food->id }}" data-name="{{ $food->name }}" data-price="{{ $food->price }}">

                    <div class="col">
                        <img src="{{ asset('images/662722.png') }}" alt="combo1">
                        <div class="row">
                            <div class="combo-title">{{ $food->name }}</div>
                            <div class="quantity-control">
                                <button class="minus">-</button>
                                <span class="number">0</span>
                                <button class="plus">+</button>
                            </div>
                        </div>

                    </div>

                    <div class="combo-price">
                        <p>{{ $food->price }} VND</p>
                    </div>

                </div>
                @endforeach



            </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const foodItems = document.querySelectorAll('.combo-item');
    const selectedFoods = new Map(JSON.parse(sessionStorage.getItem('selectedFoodsMap') || '[]'));

    foodItems.forEach(item => {
        const foodId = item.dataset.id;
        const name = item.dataset.name;
        const price = parseInt(item.dataset.price);

        const minusBtn = item.querySelector('.minus');
        const plusBtn = item.querySelector('.plus');
        const numberSpan = item.querySelector('.number');

        let quantity = selectedFoods.has(foodId) ? selectedFoods.get(foodId).quantity : 0;
        numberSpan.textContent = quantity;

        function updateStorage() {
            if (quantity > 0) {
                selectedFoods.set(foodId, { name, price, quantity });
            } else {
                selectedFoods.delete(foodId);
            }

            sessionStorage.setItem('selectedFoodsMap', JSON.stringify(Array.from(selectedFoods.entries())));
            updateFoodSummary();    
        }

        minusBtn.addEventListener('click', () => {
            if (quantity > 0) {
                quantity--;
                numberSpan.textContent = quantity;
                updateStorage();
            }
        });

        plusBtn.addEventListener('click', () => {
            quantity++;
            numberSpan.textContent = quantity;
            updateStorage();
        });
    });

    function updateFoodSummary() {
        const selectedFoodsDiv = document.getElementById('selected-foods');
        const totalDiv = document.getElementById('total-price');
        const seatTotal = parseInt(sessionStorage.getItem('ticketTotal') || '0');

        let foodHtml = '';
        let foodTotal = 0;

        selectedFoods.forEach(food => {
            const subtotal = food.quantity * food.price;
            foodHtml += `<p class="info">${food.name} x${food.quantity} <strong style="float:right">${formatPrice(subtotal)}</strong></p>`;
            foodTotal += subtotal;
        });

        selectedFoodsDiv.innerHTML = foodHtml || '<p class="text-muted">Chưa chọn combo</p>';

        const finalTotal = seatTotal + foodTotal;
        totalDiv.textContent = formatPrice(finalTotal);
        sessionStorage.setItem('finalTotal', finalTotal);
    }

    function formatPrice(number) {
        return number.toLocaleString('vi-VN') + ' VND';
    }

    updateFoodSummary(); // gọi ngay để hiển thị nếu đã chọn
});
</script>

<style>
          .container-combo {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 30px;
}

.left-box {
    flex: 1 1 60%;
    background-color: #fff;
    padding: 20px;
    border-radius: 16px;
    border: 1px solid #e0e0e0;
}

.right-box {
    flex: 1 1 35%;
    background-color: #fff;
    padding: 20px;
    border-radius: 16px;
    border: 1px solid #e0e0e0;
    height: fit-content;
}

.tag-button {
    font-size: 20px;
    font-weight: bold;
    color: #67B72F;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.combo-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px dashed #ddd;
    padding: 15px 0;
}

.combo-item img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 12px;
    margin-right: 15px;
    border: 1px solid #ccc;
}

.combo-item .col {
    display: flex;
    align-items: center;
    flex: 1;
}

.combo-title {
    font-weight: bold;
    font-size: 16px;
    margin-bottom: 6px;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 5px;
}

.quantity-control button {
    background-color: #67B72F;
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    font-size: 18px;
    border-radius: 50%;
    cursor: pointer;
    transition: 0.2s;
}

.quantity-control button:hover {
    background-color: #4a8f25;
}

.quantity-control .number {
    font-weight: bold;
    font-size: 16px;
    width: 24px;
    text-align: center;
}

.combo-price {
    text-align: right;
    min-width: 90px;
}

.combo-price del {
    color: #999;
    font-size: 14px;
}

.combo-price p {
    margin: 0;
    color: #E53935;
    font-weight: bold;
    font-size: 15px;
}

/* Right box styling */
.right-box .title {
    font-weight: bold;
    font-size: 18px;
    margin-top: 10px;
    margin-bottom: 5px;
}

.right-box .info {
    font-size: 14px;
    margin-bottom: 10px;
}

.right-box .total {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    font-size: 16px;
    color: #67B72F;
    margin-top: 20px;
}

.right-box .note {
    font-size: 13px;
    color: #999;
}

.btn-checkout {
    display: block;
    width: 100%;
    background: linear-gradient(to top, #99dc3c, #3fb83f);
    color: white;
    font-weight: bold;
    font-size: 16px;
    padding: 12px;
    border: none;
    border-radius: 10px;
    margin-top: 20px;
    text-align: center;
    text-decoration: none;
    transition: 0.3s ease;
}

.btn-checkout:hover {
    background: linear-gradient(to top, #3fb83f, #3fb83f);
}

.btn-back-wrapper {
    text-align: center;
    margin-top: 15px;
}

.btn-back {
    color: #67B72F;
    text-decoration: none;
    font-size: 15px;
}

@media (max-width: 768px) {
    .container-combo {
        flex-direction: column;
    }

    .left-box,
    .right-box {
        flex: 1 1 100%;
    }

    .combo-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .combo-item .col {
        flex-direction: column;
        align-items: flex-start;
    }

    .combo-price {
        align-self: flex-end;
    }
}

    </style>
