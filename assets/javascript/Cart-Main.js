// Lấy giỏ hàng từ localStorage
var cart = JSON.parse(localStorage.getItem("cart")) || [];

// Tải danh sách sản phẩm vào giỏ hàng trong trang cart.html
var cartItemsContainer = document.getElementById("cart_items");

// Lặp qua từng sản phẩm trong giỏ hàng và thêm vào bảng
cart.forEach(function (item) {
  var addtr = document.createElement("tr");
  var trContent = `
    <td><img src="${item.image}" alt="${item.name}" width="100"></td>
    <td>${item.name}</td>
    <td><span class="price">${item.price}</span><sup>đ</sup></td>
    <td><input type="number" value="${item.quantity || 1}" min="1"></td>
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
    productPrice = productPrice.replace(/\./g, ''); // Loại bỏ dấu chấm trong giá
    var totalA = Number(inputValue) * Number(productPrice);

    totalC += totalA;
  }
  var cartTotalA = document.querySelector(".price-total span");
  cartTotalA.innerHTML = totalC.toLocaleString('de-DE'); // Hiển thị tổng giá dạng tiền tệ
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
    var quantity = row.querySelector("td input").value;
    updatedCart.push({ image: image, name: name, price: price, quantity: Number(quantity) });
  });
  localStorage.setItem("cart", JSON.stringify(updatedCart));
}

// -------------------------Thay đổi số lượng (Input Change)------------------------------
function inputchange() {
  var cartItem = document.querySelectorAll("tbody tr");
  cartItem.forEach(function (item) {
      var inputValue = item.querySelector("input");
      inputValue.addEventListener("change", function (event) {
          var newQuantity = event.target.value;
          var productName = item.querySelector("td:nth-child(2)").innerText;

          updateProductQuantity(productName, newQuantity); // Gọi hàm cập nhật số lượng
          carttotal();
      });
  });
}

// Hàm cập nhật số lượng sản phẩm trong localStorage
function updateProductQuantity(productName, newQuantity) {
  // Lấy giỏ hàng từ localStorage
  var cart = JSON.parse(localStorage.getItem("cart")) || [];
  cart.forEach(function (item) {
    if (item.name === productName) {
      item.quantity = Number(newQuantity); // Cập nhật số lượng
    }
  });
  localStorage.setItem("cart", JSON.stringify(cart)); // Cập nhật lại localStorage
}

// -------------------------Thêm sản phẩm vào giỏ hàng từ index.html------------------------------
function addToCart(product) {
  var cart = JSON.parse(localStorage.getItem("cart")) || [];
  var existingProduct = cart.find(item => item.name === product.name);

  if (existingProduct) {
    existingProduct.quantity += 1; // Tăng số lượng nếu sản phẩm đã tồn tại
  } else {
    cart.push({ ...product, quantity: 1 }); // Thêm sản phẩm mới với số lượng 1
  }

  localStorage.setItem("cart", JSON.stringify(cart)); // Cập nhật lại localStorage
}
