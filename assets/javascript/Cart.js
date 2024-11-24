// Lấy tất cả các nút và thêm sự kiện click
const btn = document.querySelectorAll(".prod_1 button");
btn.forEach(function(button) {
    button.addEventListener("click", function(event) {
        var btnItem = event.target;
        var product = btnItem.parentElement;
        var productImg = product.querySelector("#image").src;
        var productName = product.querySelector(".product_name").innerText;
        var productPrice = product.querySelector(".prices").innerText;
        addcart(productPrice, productImg, productName);

        // Lưu sản phẩm vào localStorage
        var productData = {
            name: productName,
            price: productPrice,
            image: productImg
        };
        var cart = JSON.parse(localStorage.getItem("cart")) || [];
        cart.push(productData);
        localStorage.setItem("cart", JSON.stringify(cart));
    });
});

// Thêm sản phẩm vào bảng
function addcart(productPrice, productImg, productName) {
    var addtr = document.createElement("tr");
    var cartItem = document.querySelectorAll("tbody tr");
    for (var i = 0; i < cartItem.length; i++) {
        var productT = document.querySelectorAll(".title");
        if (productT[i].innerHTML === productName) {
            alert("Sản phẩm đã có trong giỏ hàng");
            return;
        }
    }

    var trcontent = `
        <tr>
            <td style="display: flex; align-items: center;">
                <img src="${productImg}" alt="${productName}">
                <span class="title">${productName}</span>
            </td>
            <td><p><span class="price">${productPrice}</span><sup>đ</sup></p></td>
            <td><input type="number" value="1" min="1"></td>
            <td style="cursor: pointer;"><span class="cart-delete">Xóa</span></td>
        </tr>`;
    addtr.innerHTML = trcontent;
    var cartTable = document.querySelector("tbody");
    cartTable.append(addtr);

    carttotal();
    deleteCart();

    // Cập nhật vào localStorage
    var productData = { name: productName, price: productPrice, image: productImg, quantity: 1 };
    updateProductQuantity(productName, 1); // Đảm bảo số lượng mặc định là 1
}

// Tính tổng giá tiền
function carttotal() {
    var cartItem = document.querySelectorAll("tbody tr");
    var totalC = 0;
    for (var i = 0; i < cartItem.length; i++) {
        var inputValue = cartItem[i].querySelector("td input").value;
        var productPrice = cartItem[i].querySelector(".price").innerHTML;
        productPrice = productPrice.replace(/\./g, '');
        totalA = Number(inputValue) * Number(productPrice);
        totalC += totalA;
    }
    var cartTotalA = document.querySelector(".price-total span");
    cartTotalA.innerHTML = totalC.toLocaleString('de-DE');
    inputchange();
}

// Xóa sản phẩm khỏi giỏ hàng
function deleteCart() {
    var cartItem = document.querySelectorAll("tbody tr");
    cartItem.forEach(function(item, index) {
        var deleteBtn = item.querySelector(".cart-delete");
        deleteBtn.addEventListener("click", function() {
            item.remove();
            carttotal();
            removeFromLocalStorage(index);
        });
    });
}

// Xóa sản phẩm khỏi localStorage
function removeFromLocalStorage(index) {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));
}

// Cập nhật số lượng sản phẩm
function inputchange() {
    var cartItem = document.querySelectorAll("tbody tr");
    cartItem.forEach(function(item) {
        var inputValue = item.querySelector("input");
        inputValue.addEventListener("change", function() {
            carttotal();
        });
    });
}

// Tải sản phẩm từ localStorage khi trang tải
document.addEventListener("DOMContentLoaded", function() {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.forEach(function(product) {
        addcart(product.price, product.image, product.name);
    });
});
// Cập nhật số lượng sản phẩm
function inputchange() {
    var cartItem = document.querySelectorAll("tbody tr");
    cartItem.forEach(function (item) {
        var inputValue = item.querySelector("input");
        inputValue.addEventListener("change", function () {
            var newQuantity = inputValue.value;
            var productName = item.querySelector(".title").innerText;

            updateProductQuantity(productName, newQuantity); // Cập nhật số lượng vào localStorage
            carttotal();
        });
    });
}

// Cập nhật số lượng sản phẩm trong localStorage
function updateProductQuantity(productName, newQuantity) {
    var cart = JSON.parse(localStorage.getItem("cart")) || [];
    cart.forEach(function (item) {
        if (item.name === productName) {
            item.quantity = Number(newQuantity); // Cập nhật số lượng
        }
    });
    localStorage.setItem("cart", JSON.stringify(cart)); // Lưu lại vào localStorage
}