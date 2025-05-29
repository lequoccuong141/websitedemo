-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 15, 2025 lúc 08:38 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_mysqli`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `admin_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `username`, `password`, `admin_status`) VALUES
(5, 'admin', '1', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_chitietdonhang`
--

CREATE TABLE `tbl_chitietdonhang` (
  `id_chitiet` int(11) NOT NULL,
  `id_donhang` int(11) NOT NULL,
  `id_sanpham` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `soluong` int(11) NOT NULL,
  `giasp` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_chitietdonhang`
--

INSERT INTO `tbl_chitietdonhang` (`id_chitiet`, `id_donhang`, `id_sanpham`, `quantity`, `price`, `soluong`, `giasp`) VALUES
(40, 36, 52, 0, 0.00, 1, 9490000.00),
(41, 37, 65, 0, 0.00, 2, 1757000.00),
(43, 39, 65, 0, 0.00, 1, 1757000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_dangky`
--

CREATE TABLE `tbl_dangky` (
  `id_dangky` int(11) NOT NULL,
  `tenkhachhang` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `diachi` varchar(100) NOT NULL,
  `matkhau` varchar(50) NOT NULL,
  `dienthoai` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_dangky`
--

INSERT INTO `tbl_dangky` (`id_dangky`, `tenkhachhang`, `email`, `diachi`, `matkhau`, `dienthoai`) VALUES
(64, 'user123', 'testuser@example.com', 'Cần Thơ Cái Răng', '123456789', '0123456789');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_danhmuc`
--

CREATE TABLE `tbl_danhmuc` (
  `id_danhmuc` int(11) NOT NULL,
  `tendanhmuc` varchar(50) NOT NULL,
  `thutu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_danhmuc`
--

INSERT INTO `tbl_danhmuc` (`id_danhmuc`, `tendanhmuc`, `thutu`) VALUES
(45, 'Điện thoại', 1),
(46, 'Sạc dự phòng', 2),
(47, 'Tai nghe', 3),
(48, 'Sạc SamSung', 4),
(49, 'Sạc Apple', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_donhang`
--

CREATE TABLE `tbl_donhang` (
  `id_donhang` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `date_order` datetime DEFAULT current_timestamp(),
  `status_approval` enum('pending','approved','rejected') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_donhang`
--

INSERT INTO `tbl_donhang` (`id_donhang`, `fullname`, `phone`, `email`, `address`, `notes`, `payment_method`, `total`, `date_order`, `status_approval`) VALUES
(36, 'Nguyễn văn A', '0123456789', 'testuser@example.com', 'Cần Thơ,Hưng Phú ,Cái Răng', 'Giao nhanh giúp tôi', 'cod', 9490000.00, '2025-04-15 23:28:55', 'pending'),
(37, 'Nguyễn văn B', '01234345', 'testuser@example.com', 'Cần Thơ', 'Nhanh', 'cod', 3514000.00, '2025-04-16 00:02:11', 'pending'),
(39, 'Nguyễn văn C', 'sdasdasdasdasdasdasd', 'testuser@example.com', 'ewq', 'qưe', 'cod', 1757000.00, '2025-04-16 00:08:23', 'pending');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_sanpham`
--

CREATE TABLE `tbl_sanpham` (
  `id_sanpham` int(11) NOT NULL,
  `tensanpham` varchar(50) NOT NULL,
  `masp` varchar(50) NOT NULL,
  `giasp` varchar(50) NOT NULL,
  `soluong` varchar(50) NOT NULL,
  `hinhanh` blob NOT NULL,
  `tomtat` varchar(1000) NOT NULL,
  `noidung` varchar(1000) NOT NULL,
  `tinhtrang` varchar(100) NOT NULL,
  `id_danhmuc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_sanpham`
--

INSERT INTO `tbl_sanpham` (`id_sanpham`, `tensanpham`, `masp`, `giasp`, `soluong`, `hinhanh`, `tomtat`, `noidung`, `tinhtrang`, `id_danhmuc`) VALUES
(50, 'Samsung Galaxy A56 5G 8GB/128GB      ', '111', '9490000', '10', 0x7373312e706e67, 'Màn hình:	Super AMOLED 6.7\" Full HD+\r\nHệ điều hành:	Android 15\r\nCamera sau:	Chính 50 MP & Phụ 12 MP, 5 MP\r\nCamera trước:	12 MP\r\nChip:	Exynos 1580 8 nhân\r\nRAM:	8 GB\r\nDung lượng lưu trữ:	128 GB\r\nSIM:	2 Nano SIM hoặc 2 eSIM hoặc 1 Nano SIM + 1 eSIMHỗ trợ 5G\r\nPin, Sạc:	5000 mAh45 W\r\nHãng	Samsung.', 'Samsung Galaxy A56 5G 8GB/128GB mang đến trải nghiệm mạnh mẽ với thiết kế sang trọng, độ bền cao và hiệu suất ổn định. Máy được trang bị camera sắc nét, pin dung lượng lớn và nhiều tính năng thông minh, hỗ trợ tối đa cho công việc, giải trí và kết nối. Đây là lựa chọn lý tưởng cho những ai cần một chiếc smartphone linh hoạt, đáp ứng trọn vẹn nhu cầu sử dụng hàng ngày.\r\nKhám phá sức mạnh AI, trải nghiệm di động đỉnh cao', '1', 45),
(51, 'Samsung Galaxy A26 6GB/128GB\r\n      ', '112', '6590000', '10', 0x7373322e706e67, 'Màn hình:	Super AMOLED 6.7\" Full HD+\r\nHệ điều hành:	Android 15\r\nCamera sau:	Chính 50 MP & Phụ 8 MP, 2 MP\r\nCamera trước:	13 MP\r\nChip:	Exynos 1380 8 nhân\r\nRAM:	6 GB\r\nDung lượng lưu trữ:	128 GB\r\nSIM:	2 Nano SIM (SIM 2 chung khe thẻ nhớ)Hỗ trợ 5G\r\nPin, Sạc:	5000 mAh25 W\r\nHãng	Samsung.', 'Samsung Galaxy A26 6GB/128GB trang bị màn hình 120 Hz mượt mà, chip Exynos 1380 mạnh mẽ và camera 50 MP OIS sắc nét, giúp ghi lại hình ảnh sống động. Máy có thiết kế hiện đại, pin 5000 mAh bền bỉ, sạc nhanh 25W và đạt chuẩn kháng nước, bụi IP67, mang đến sự bền bỉ và tiện lợi cho người dùng năng động.\r\nMàn hình 120Hz siêu mượt, trải nghiệm sống động\r\nSamsung Galaxy A26 5G sở hữu màn hình lớn 6.7 inch Full HD+ (1080 x 2340 pixels), mang đến không gian hiển thị sắc nét, chân thực. Với tần số quét 120 Hz giúp mọi thao tác vuốt chạm, cuộn trang hay chuyển đổi ứng dụng diễn ra mượt mà, nhanh nhạy như trên các flagship cao cấp.', '1', 45),
(52, 'Samsung Galaxy A36 5G 8GB/128GB \r\n      ', '113', '9490000', '10', 0x7373332e706e67, 'Màn hình:	Super AMOLED 6.7\" Full HD+\r\nHệ điều hành:	Android 15\r\nCamera sau:	Chính 50 MP & Phụ 12 MP, 5 MP\r\nCamera trước:	12 MP\r\nChip:	Exynos 1580 8 nhân\r\nRAM:	8 GB\r\nDung lượng lưu trữ:	128 GB\r\nSIM:	2 Nano SIM hoặc 2 eSIM hoặc 1 Nano SIM + 1 eSIMHỗ trợ 5G\r\nPin, Sạc:	5000 mAh45 W\r\nHãng	Samsung.', 'Samsung Galaxy A36 5G 8GB/128GB sở hữu hiệu năng mạnh mẽ với màn hình Super AMOLED 6.7 inch sắc nét và vi xử lý Snapdragon 6 Gen 3. Tính năng AI thông minh giúp tối ưu hóa trải nghiệm sử dụng, mang lại sự tiện lợi. Máy có thiết kế nguyên khối, kết hợp với mặt lưng kính, vừa sang trọng vừa tạo cảm giác thoải mái khi cầm nắm suốt cả ngày.\r\nTrải nghiệm tốc độ vượt trội, mượt mà mọi tác vụ\r\nSamsung Galaxy A36 mang đến hiệu suất mạnh mẽ với vi xử lý Snapdragon 6 Gen 3 8 nhân, đạt tốc độ tối đa 2.4 GHz, kết hợp chip đồ họa Adreno 710. Điều này giúp máy xử lý mọi tác vụ từ công việc cho đến giải trí một cách nhanh chóng và mượt mà, không gặp phải bất kỳ độ trễ nào.', '1', 45),
(54, 'iPhone 15 Pro Max 256GB\r\n      ', '114', '28490000', '10', 0x61312e77656270, 'Chip\r\n\r\nApple A17 Pro\r\n\r\nKích thước màn hình\r\n\r\n6.7\r\n\r\nThời lượng pin\r\n\r\n29', 'Chính sách sản phẩm\r\nHàng chính hãng - Bảo hành 12 tháng\r\nHàng chính hãng - Bảo hành 12 tháng\r\nGiao hàng toàn quốc\r\nGiao hàng toàn quốc\r\nKỹ thuật viên hỗ trợ trực tuyến\r\nKỹ thuật viên hỗ trợ trực tuyến', '1', 45),
(55, 'iPhone 15 128GB\r\n      ', '115', '15990000', '10', 0x61322e77656270, 'Chip\r\n\r\nApple A16 Bionic\r\n\r\nKích thước màn hình\r\n\r\n6.1\r\n\r\nThời lượng pin\r\n\r\n20', 'Chính sách sản phẩm\r\nHàng chính hãng - Bảo hành 12 tháng\r\nHàng chính hãng - Bảo hành 12 tháng\r\nGiao hàng toàn quốc\r\nGiao hàng toàn quốc\r\nKỹ thuật viên hỗ trợ trực tuyến\r\nKỹ thuật viên hỗ trợ trực tuyến', '1', 45),
(56, 'iPhone 16 Pro Max 256GB      ', '116', '31090000', '10', 0x61332e77656270, 'Chip\r\n\r\nApple A18 Pro\r\n\r\nKích thước màn hình\r\n\r\n6.9\r\n\r\nThời lượng pin\r\n\r\n33', 'Chính sách sản phẩm\r\n\r\nHàng chính hãng - Bảo hành 12 tháng\r\nHàng chính hãng - Bảo hành 12 tháng\r\nGiao hàng toàn quốc\r\nGiao hàng toàn quốc\r\nKỹ thuật viên hỗ trợ trực tuyến\r\nKỹ thuật viên hỗ trợ trực tuyến', '1', 45),
(57, 'Sạc dự phòng MagSafe Battery Pack\r\n      ', '221', '2290000', '10', 0x70312e77656270, 'Thông tin hàng hóa\r\nModel\r\nSạc dự phòng MagSafe Battery Pack\r\nXuất xứ\r\nTrung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nMàu sắc\r\nTrắng\r\n\r\nThiết kế & Trọng lượng\r\nTrọng lượng sản phẩm\r\n185 g\r\n\r\nThông số cơ bản\r\nLoại Sạc - Cáp\r\nSạc dự phòng\r\n\r\nCường độ dòng điện\r\n15W\r\n\r\nSử dụng cho thiết bị\r\niPhone\r\n\r\nGiao tiếp và kết nối\r\nCổng cáp kết nối\r\nĐầu vào: Lightning\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nSạc không dây', 'Mô tả sản phẩm\r\nNếu bạn đang sử dụng những chiếc iPhone đời mới của Apple, sạc dự phòng MagSafe Battery Pack sẽ là một phụ kiện tuyệt vời để bổ sung năng lượng bất cứ lúc nào bạn cần.\r\n\r\nSạc không cần tới cáp', '1', 46),
(58, 'Sạc dự phòng Samsung 20.000mAh - 25W\r\n      ', '222', '1192000', '10', 0x70322e77656270, 'Thông tin hàng hóa\r\nModel\r\n20.000mAh\r\nXuất xứ\r\nViệt Nam / Trung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nĐơn vị tính\r\nChiếc\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nMàu sắc\r\nXám\r\n\r\nThiết kế & Trọng lượng\r\nKích thước\r\n69.2 x 143.1 x 25.43 mm\r\nTrọng lượng sản phẩm\r\n392 g\r\n\r\nChất liệu\r\nHợp kim nhôm\r\n\r\nThông số cơ bản\r\nLoại sạc\r\nSạc dự phòng\r\n\r\nThời gian sạc đầy\r\n8 - 11 giờ\r\n\r\nSử dụng cho thiết bị\r\nMáy tính bảng\r\n\r\nThông tin pin & sạc\r\nLoại PIN\r\nLithium polymer\r\nDung lượng pin\r\n20000 mAh\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nLõi pin cao cấp\r\n\r\nQuản lý nguồn\r\n\r\nTự động cân bằng thời gian sạc và hiệu chỉnh dòng\r\n\r\nSạc nhanh 25W\r\n\r\nPhụ kiện trong hộp\r\nPhụ kiện đi kèm\r\nSách HDSD\r\n\r\nCáp USB-C to USB-C', 'Mô tả sản phẩm\r\nKhông chỉ có dung lượng cao, pin sạc dự phòng Samsung 20000mAh EB-P5300 còn hỗ trợ công nghệ sạc nhanh và khả năng tương thích tuyệt vời. Sản phẩm không quá to và nặng, tích hợp nhiều chế độ an toàn khác nhau.\r\n\r\nHỗ trợ công nghệ sạc nhanh 25W', '1', 46),
(59, 'Trạm sạc dự phòng Yoobao 72000mAh PD 65W EN300WLPD', '223', '3990000', '10', 0x70332e77656270, 'Thông tin hàng hóa\r\nModel\r\nEN300WLPD\r\nXuất xứ\r\nTrung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nMàu sắc\r\nĐen\r\n\r\nThiết kế & Trọng lượng\r\nKích thước\r\n268 x 110 x 185 mm\r\nTrọng lượng sản phẩm\r\n3092 g\r\n\r\nChất liệu\r\nHợp kim nhôm\r\n\r\nThông số cơ bản\r\nSử dụng cho thiết bị\r\nĐiện thoại\r\n\r\nMáy tính bảng\r\n\r\nGiao tiếp và kết nối\r\nCổng giao tiếp đầu vào\r\n1 x USB-C\r\n\r\nCổng giao tiếp đầu ra\r\n2 x USB-A\r\n\r\n1 x USB-C\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nCó cổng USB để sạc', 'Mô tả sản phẩm\r\nTrạm sạc dự phòng Yoobao 72000mAh PD 65W EN300WLPD là một thiết bị sạc đa năng và mạnh mẽ, được thiết kế để đáp ứng nhu cầu cung cấp năng lượng cho các thiết bị điện tử hàng ngày. Với dung lượng pin lớn, công suất vượt trội cùng nhiều cổng sạc tiện lợi, sản phẩm này sẽ là một giải pháp lý tưởng cho những ai đang cần một nguồn năng lượng di động và linh hoạt. \r\n\r\nThiết kế tiện lợi và hiện đại\r\nTrạm sạc dự phòng Yoobao 72000mAh PD 65W EN300WLPD có thiết kế vô cùng tiện lợi và hiện đại. Với kích thước 268 x 110 x 185 mm và trọng lượng khoảng 3.09 gam, trạm sạc này rất dễ dàng mang theo và sử dụng ở nhiều nơi khác nhau. Thiết bị được trang bị tay cầm chắc chắn, giúp người dùng linh hoạt trong việc di chuyển. Đồng thời, màu xám thanh lịch của trạm sạc cũng mang lại cảm giác sang trọng và tinh tế.\r\n\r\nMặt trước của thiết bị được bố trí các cổng sạc và nút điều khiển, giúp dễ dàng nhận diện và thao tác nhanh chóng. Đặc biệt, thiết bị còn tích hợp hệ thống đèn LED đa năng, bao g', '1', 46),
(60, 'Tai nghe AirPods Max\r\n      ', '331', '12190000', '10', 0x74312e77656270, 'Thông tin hàng hóa\r\nModel\r\nTai nghe AirPods Max\r\nXuất xứ\r\nTrung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nMàu sắc\r\nXanh\r\n\r\nThiết kế & Trọng lượng\r\nKích thước\r\n187.3 x 168.6 x 83.4 mm\r\nChất liệu\r\nVải\r\n\r\nKhung máy: Kim loại\r\n\r\nThông số cơ bản\r\nLoại tai nghe\r\nTai nghe chụp tai\r\n\r\nThời gian sạc đầy\r\n5 phút\r\n\r\nKiểu kết nối\r\nBluetooth\r\n\r\nThông tin pin & sạc\r\nDung lượng pin\r\n20 Giờ\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nNghe nhạc\r\n\r\nChống ồn\r\n\r\nHệ điều hành\r\nHệ điều hành tương thích\r\niPadOS', 'Mô tả sản phẩm\r\nLà chiếc AirPods đầu tiên trong lịch sử Apple đi theo phong cách thiết kế over-ear chuyên dụng, AirPods Max đem tới sự cân bằng hoàn hảo giữa trải nghiệm âm thanh trung thực và tính tiện dụng đặc trưng của dòng tai nghe đến từ Táo khuyết.\r\n\r\n', '1', 47),
(61, 'Tai nghe Bose QuietComfort Earbuds\r\n      ', '332', '4490000', '10', 0x74322e77656270, 'Thông tin hàng hóa\r\nModel\r\nQuietComfort Earbuds\r\nXuất xứ\r\nTrung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nMàu sắc\r\nĐen\r\n\r\nThiết kế & Trọng lượng\r\nKích thước\r\n2.9 x 2.7 x 2.1 (cm)\r\nTrọng lượng sản phẩm\r\n8.5 g\r\n\r\nChất liệu\r\nPlastic\r\n\r\nSilicone\r\n\r\nKim loại\r\n\r\nThông số cơ bản\r\nLoại tai nghe\r\nTai nghe không dây\r\n\r\nThời gian sạc đầy\r\n2 giờ\r\n\r\nThời gian sử dụng/1 lần sạc\r\n8.5 giờ Chế độ bình thường\r\n\r\nKhoảng cách kết nối\r\n9 m\r\nBảng điều khiển\r\nCảm ứng Tiếng Anh\r\n\r\nKiểu kết nối\r\nBluetooth\r\n\r\nSử dụng cho thiết bị\r\nĐiện thoại\r\n\r\nGiao tiếp và kết nối\r\nBluetooth\r\nv5.3\r\n\r\nCổng giao tiếp\r\nCổng sạc: Type C\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nChống ồn\r\n\r\nPhụ kiện trong hộp\r\nPhụ kiện đi kèm\r\nCáp USB-A to USB-C\r\n\r\nHộp sạc không dây', 'Mô tả sản phẩm\r\nTai nghe Bose QuietComfort Earbuds là một sản phẩm cao cấp với khả năng khử ồn chủ động hàng đầu. Thiết bị này được thiết kế dành riêng cho những ai mong muốn trải nghiệm âm thanh chất lượng, loại bỏ tiếng ồn xung quanh và tập trung vào hoàn toàn vào nội dung yêu thích. Với thời lượng pin dài và khả năng chống nước chuẩn IPX4, Bose QuietComfort Earbuds là lựa chọn lý tưởng cho các hoạt động hàng ngày từ nghe nhạc, cuộc gọi đến thể thao nhẹ nhàng.\r\n\r\nKiểu dáng vừa vặn và thoải mái khi đeo\r\nBose QuietComfort Earbuds nổi bật với thiết kế nhỏ gọn nhưng vẫn đảm bảo sự ổn định và thoải mái khi đeo. Thiết bị được tích hợp ba kích cỡ nút tai và đai cố định, giúp người dùng tùy chỉnh để vừa vặn với tai mình, mang lại cảm giác dễ chịu trong thời gian dài sử dụng.\r\n\r\nVới chất liệu cao cấp, Bose QuietComfort không chỉ nhẹ (8.5 gam mỗi bên) mà còn có độ bền cao. Kích thước tai nghe gọn gàng 2.9 x 2.7 x 2.1 cm, cho phép người dùng dễ dàng mang theo, đặc biệt là khi đi cùng hộp sạc nh', '1', 47),
(62, 'Củ sạc nhanh Samsung 15W Type-C\r\n      ', '441', '256000', '10', 0x71312e77656270, 'Thông tin hàng hóa\r\nModel\r\n15w USB-C\r\nXuất xứ\r\nViệt Nam\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nMàu sắc\r\nTrắng\r\n\r\nThiết kế & Trọng lượng\r\nTrọng lượng sản phẩm\r\n125 g\r\n\r\nThông số cơ bản\r\nLoại Sạc - Cáp\r\nAdapter sạc\r\n\r\nSử dụng cho thiết bị\r\nĐiện thoại\r\n\r\nGiao tiếp và kết nối\r\nCổng cáp kết nối\r\nType C\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nSạc nhanh\r\n\r\nTương thích hoàn hảo với nhiều thiết bị', 'Mô tả sản phẩm\r\nNếu bạn đang tìm kiếm một giải pháp sạc hiệu quả cho điện thoại Galaxy, củ sạc nhanh Samsung 15W Type C sẽ là một trong những lựa chọn lý tưởng dành cho bạn. Thiết kế nhỏ gọn, hỗ trợ sạc nhanh và độ an toàn cao là những tính năng nổi bật trên sản phẩm này.\r\n\r\nNhỏ gọn đáng kinh ngạc', '1', 48),
(63, 'Củ sạc nhanh Samsung 25W Type C - TA800\r\n      ', '442', '392000', '10', 0x71322e77656270, 'Thông tin hàng hóa\r\nModel\r\n25w USB-C\r\nXuất xứ\r\nViệt Nam / Trung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nHướng dẫn bảo quản\r\nĐể nơi khô ráo, nhẹ tay, dễ vỡ.\r\nHướng dẫn sử dụng\r\nXem trong sách hướng dẫn sử dụng\r\nMàu sắc\r\nTrắng\r\n\r\nThiết kế & Trọng lượng\r\nTrọng lượng sản phẩm\r\n0 g\r\n\r\nThông số cơ bản\r\nSử dụng cho thiết bị\r\nĐiện thoại\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nSạc', 'Giảm ngay 500,000đ cho đơn trên 15 triệu khi trả góp 100% qua thẻ VISA (áp dụng Sacombank và Muadee by HDBank) Xem chi tiết', '1', 48),
(64, 'Củ sạc Apple Power Adapter 140W Type-C\r\n      ', '551', '2204000', '10', 0x7a312e77656270, 'Thông tin hàng hóa\r\nModel\r\n140W USB-C\r\nXuất xứ\r\nTrung Quốc\r\n\r\nThời gian bảo hành\r\n12 tháng\r\nMàu sắc\r\nTrắng\r\n\r\nThiết kế & Trọng lượng\r\nTrọng lượng sản phẩm\r\n360 g\r\n\r\nThông số cơ bản\r\nLoại Sạc - Cáp\r\nAdapter sạc\r\n\r\nCường độ dòng điện\r\n140W\r\n\r\nSử dụng cho thiết bị\r\nMáy tính để bàn\r\n\r\nGiao tiếp và kết nối\r\nCổng cáp kết nối\r\nType C\r\n\r\nTính năng và tiện ích\r\nTính năng\r\nSạc nhanh\r\n\r\nSạc 140W USB-C Power Adapter', 'Mô tả sản phẩm\r\nĐược sản xuất chính hãng bởi Apple, bộ sạc 140W USB-C Power Adapter ghi nhận khả năng sạc nhanh cho MacBook Pro 16 inch (2021) và nhiều sản phẩm nằm trong hệ sinh thái của Táo khuyết. Nhờ công nghệ điều tiết dòng điện thông minh, thiết bị này sẽ giúp bạn có thể nạp năng lượng vừa an toàn, vừa hiệu quả.\r\n\r\n', '1', 49),
(65, 'Củ sạc Apple 85W Magsafe 1\r\n      ', '552', '1757000', '10', 0x7a322e77656270, 'Thông tin hàng hóa\r\nModel\r\n85W\r\nThời gian bảo hành\r\n12 tháng\r\nMàu sắc\r\nTrắng', 'Mô tả sản phẩm\r\nSạc 85W MagSafe Power Adapter được dùng để cung cấp năng lượng cho máy tính Macbook Pro 15 inch và 17 inch sử dụng cổng sạc Magsafe 1 một cách nhanh chóng và an toàn. Sản phẩm có thiết kế nhỏ gọn, thông minh cho phép cáp DC có thể quấn gọn gàng quanh chính nó giúp bạn dễ dàng mang theo khi đi du lịch hay đi công tác.\r\n\r\n', '1', 49);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Chỉ mục cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  ADD PRIMARY KEY (`id_chitiet`),
  ADD KEY `id_donhang` (`id_donhang`),
  ADD KEY `id_sanpham` (`id_sanpham`);

--
-- Chỉ mục cho bảng `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  ADD PRIMARY KEY (`id_dangky`);

--
-- Chỉ mục cho bảng `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  ADD PRIMARY KEY (`id_danhmuc`);

--
-- Chỉ mục cho bảng `tbl_donhang`
--
ALTER TABLE `tbl_donhang`
  ADD PRIMARY KEY (`id_donhang`);

--
-- Chỉ mục cho bảng `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  ADD PRIMARY KEY (`id_sanpham`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  MODIFY `id_chitiet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `tbl_dangky`
--
ALTER TABLE `tbl_dangky`
  MODIFY `id_dangky` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT cho bảng `tbl_danhmuc`
--
ALTER TABLE `tbl_danhmuc`
  MODIFY `id_danhmuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT cho bảng `tbl_donhang`
--
ALTER TABLE `tbl_donhang`
  MODIFY `id_donhang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `tbl_sanpham`
--
ALTER TABLE `tbl_sanpham`
  MODIFY `id_sanpham` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `tbl_chitietdonhang`
--
ALTER TABLE `tbl_chitietdonhang`
  ADD CONSTRAINT `tbl_chitietdonhang_ibfk_1` FOREIGN KEY (`id_donhang`) REFERENCES `tbl_donhang` (`id_donhang`),
  ADD CONSTRAINT `tbl_chitietdonhang_ibfk_2` FOREIGN KEY (`id_sanpham`) REFERENCES `tbl_sanpham` (`id_sanpham`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
