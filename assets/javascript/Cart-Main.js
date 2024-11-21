// Lấy giỏ hàng từ localStorage
var cart = JSON.parse(localStorage.getItem("cart")) || [];

var cartItemsContainer = document.getElementById("cart_items");

// Lặp qua từng sản phẩm trong giỏ hàng và thêm vào bảng
cart.forEach(function (item) {
  var addtr = document.createElement("tr");
  var trContent = `
    <td><img src="${item.image}" alt="${item.name}" width="100"></td>
    <td>${item.name}</td>
    <td><span class="price">${item.price}</span><sup>đ</sup></td>
    <td><input type="number" value="1" min="1"></td>
    <td style="cursor: pointer;"><span class="cart-delete">Xóa</span></td>
  `;
  addtr.innerHTML = trContent;
  cartItemsContainer.append(addtr);
});

// Gọi các hàm để tính tổng và thiết lập sự kiện xóa
carttotal();
deleteCart();
inputchange();

// ----------------Tính tổng tiền (Total Price)--------------------------
function carttotal() {
  var cartItem = document.querySelectorAll("tbody tr");
  var totalC = 0;
  for (var i = 0; i < cartItem.length; i++) {
    var inputValue = cartItem[i].querySelector("td input").value;
    var productPrice = cartItem[i].querySelector(".price").innerHTML;
    productPrice = productPrice.replace(/\./g, '');
    var totalA = Number(inputValue) * Number(productPrice);

    totalC += totalA;
  }
  var cartTotalA = document.querySelector(".price-total span");
  cartTotalA.innerHTML = totalC.toLocaleString('de-DE');
  inputchange();
}

// -----------------------------Xóa sản phẩm (Delete Product)-------------------------------
function deleteCart() {
  var cartItem = document.querySelectorAll("tbody tr");
  for (var i = 0; i < cartItem.length; i++) {
    var productT = document.querySelectorAll(".cart-delete");
    productT[i].addEventListener("click", function (event) {
      var cartDelete = event.target;
      var cartitemR = cartDelete.parentElement.parentElement;
      cartitemR.remove();
      carttotal();
      // Cập nhật lại localStorage sau khi xóa sản phẩm
      updateLocalStorage();
    });
  }
}

// -----------------------------Cập nhật localStorage (Update LocalStorage)-------------------------------
function updateLocalStorage() {
  var updatedCart = [];
  var cartItem = document.querySelectorAll("tbody tr");
  cartItem.forEach(function (row) {
    var image = row.querySelector("td img").src;
    var name = row.querySelector("td:nth-child(2)").innerText;
    var price = row.querySelector(".price").innerText;
    updatedCart.push({ image: image, name: name, price: price });
  });
  localStorage.setItem("cart", JSON.stringify(updatedCart));
}

// -------------------------Thay đổi số lượng (Input Change)------------------------------
function inputchange() {
  var cartItem = document.querySelectorAll("tbody tr");
  for (var i = 0; i < cartItem.length; i++) {
    var inputValue = cartItem[i].querySelector("input");
    inputValue.addEventListener("change", function () {
      carttotal();
    });
  }
}