CREATE TABLE Users (
    ID INT IDENTITY(1,1) PRIMARY KEY, -- ID tự động tăng
    Username NVARCHAR(50) NOT NULL UNIQUE, -- Username không trùng
    Email NVARCHAR(100) UNIQUE, -- Email không trùng
    Password NVARCHAR(255) NOT NULL, -- Lưu mật khẩu đã băm
    CreatedAt DATETIME DEFAULT GETDATE() -- Thời gian tạo tài khoản
);

select * from Users

delete from Users