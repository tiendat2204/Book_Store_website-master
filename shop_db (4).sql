-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 05:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Động Vật'),
(2, 'Tâm Lý'),
(3, 'Kinh Dị '),
(4, 'Đời Sống'),
(5, 'ds');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `message` varchar(200) NOT NULL,
  `reply_message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `user_id`, `number`, `message`) VALUES
(21, 85, '0354411541', 'hong co duoc'),
(22, 85, '0354411541', 'dsad');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_price` int(11) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Đợi xác nhận',
  `order_code` varchar(150) NOT NULL,
  `total_orders` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `method`, `address`, `total_price`, `placed_on`, `payment_status`, `order_code`, `total_orders`) VALUES
(449, 85, 'thanh toán khi nhận hàng', '256/1/6 dương quảng hàm, HỒ CHÍ MINH, VMS', 152000, '09/12/2023', 'Đợi xác nhận', 'ORDER17020948532816', 152000);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `subtotal` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `quantity`, `order_id`, `product_id`, `subtotal`) VALUES
(267, 2, 449, 141, 70000),
(268, 1, 449, 156, 82000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `status_products` varchar(20) DEFAULT 'có sẵn',
  `in4` varchar(1000) NOT NULL,
  `tacgia` varchar(100) NOT NULL,
  `nhacungcap` varchar(100) NOT NULL,
  `nhaxuatban` varchar(100) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `status_products`, `in4`, `tacgia`, `nhacungcap`, `nhaxuatban`, `discount`) VALUES
(30, '  Tu Giữa Đời Thường', 63000, 'ktwgm07agf23g4cruela6ppdpaaqkbvn.jpg', 4, 'có sẵn', 'Thế giới hiện đại, đặc biệt là nhịp sống hối hả của môi trường đô thị khiến con người ngày càng mất kết nối với tự nhiên, rời xa bản chất đích thực để chạy theo các khuôn mẫu bên ngoài. Khủng hoảng của con người đô thị hiện đại diễn ra ở hầu hết các khía cạnh đời sống, khiến chúng ta kiệt sức, thiếu thời gian, rơi vào lối sống trì trệ, chán ghét bản thân và không tìm thấy ý nghĩa sống.', 'Pedram Shojai', 'Thế Giới', 'Cornerstone', 0.00),
(32, ' The Magic of Thinking Big', 70000, 'ol7jnr0zrkv1s0cins0hb38qihu9s5yi.jpeg', 4, 'có sẵn', '    Hãy thử nghĩ về những người có mức thu nhập cao hơn bạn gấp 5 lần. Có phải họ thông minh hơn bạn gấp 5 lần? Họ làm việc vất vả hơn bạn gấp 5 lần? Nếu câu trả lời của bạn là “không” thì bạn sẽ chạm đến câu hỏi này: “Vậy, họ có những đức tính, phẩm chất hay bí quyết gì mà tôi không có?”', 'David J Schwartz ', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(37, 'Sống sót sau những cú shock kinh doanh', 40000, 'Screenshot 2023-10-11 191429.png', 3, 'có sẵn', 'Theo các chuyên gia tài chính, do ảnh hưởng của dịch COVID-19, trong 7 tháng năm 2021, gần 80.000 doanh nghiệp đã phải rời bỏ thị trường. Từ nay đến hết năm, nếu Việt Nam có thể kiểm soát được dịch bệnh và phục hồi kinh tế, số lượng doanh nghiệp phá sản cũng ở mức 100.000. Hiện mỗi tháng có khoảng 10.000 doanh nghiệp phá sản. Trường hợp nếu không kiểm soát được dịch bệnh, sẽ có khoảng 150.000 doanh nghiệp phá sản trong năm nay.', 'Sergio Bitar', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(38, '25 nhân vật lịch sử', 14000, 'qt3td7387xa8elp6gdzmnpda216dzbf6.jpeg', 3, 'có sẵn', 'Lịch sử của cả quốc gia lẫn cá nhân đều không tồn tại chữ “nếu”!\r\n\r\n\r\n\r\n    Tuy nhiên, việc suy ngẫm về từng thời điểm nào đó và đặt ra những giả thuyết “nếu…thì…” thật thú vị!\r\n\r\n\r\n\r\n    Ở trường học sinh sợ học môn lịch sử một phần là vì khi học các em có rất ít cơ hội, không gian và điều kiện đảm bảo để có thể tưởng tượng “nếu…thì…” hoặc suy ngẫm về các biến cố của quốc gia hoặc cuộc đời của các cá nhân ở nhiều góc độ khác nhau.\r\n\r\n\r\n\r\n    Lịch sử vì thế trở thành một thứ “lịch sử vô nhân xưng”, dễ rơi vào chung chung và trừu tượng. Để bù đắp nhược điểm cố hữu đó của môn lịch sử trong trường học (không chỉ là ở Việt Nam), học sinh cần đọc các sách về lịch sử ở bên ngoài.', 'Nguyễn Quốc Vương', 'Phụ nữ việt nam', 'Phụ nữ việt nam', 0.00),
(40, 'Thành Cát Tư Hãn là ai?', 25000, 'Screenshot 2023-10-11 192607.png', 3, 'có sẵn', 'Hãy cùng đọc bộ sách “Là ai? - Chân dung những người làm thay đổi thế giới\" để hiểu được những thăng trầm, những biến cố, những thành công trong cuộc đời của mỗi thiên tài. Từng câu, từng chữ miêu tả một cách chân thực nhất nội tâm cảm xúc nhân vật cũng những hình ảnh minh họa sống động giúp cho bất kỳ ai cũng có cảm nhận như chúng ta đang được chính những vị danh nhân ấy kể chuyện cho nghe vậy.', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(41, 'Bán đảo Ả rập', 27000, 'Screenshot 2023-10-11 192847.png', 3, 'có sẵn', 'Bán đảo Ả rập là đế quốc của Hồi giáo gồm 7 quốc gia: Ai cập, Syrie, Liban, Jorrdanie, Irak, Ả Rập Sesoudite, Yeman, mà cũng là đế quốc của dầu lửa, vì dầu lửa chi phối nó cũng như Hồi giáo, còn mạnh hơn Hồi giáo. Hồi giáo liên kết Ả Rập thì Dầu lửa chia rẽ Ả Rập. Và vậy mà ba bốn chục năm nay ở bán đảo Ả Rập xảy ra không biết bao nhiêu xung đột: xung đột giữa các đế quốc, xung đột giữa các quốc gia Ả Rập, xung đột giữa các đảng phái trong mỗi quốc gia... ', 'Amy Newmark', ' Cửa hàng Artbook', 'NXB Hội Nhà Văn', 0.00),
(42, 'Hồi ký Nguyễn Hiến Lê', 28000, 'jpr71l14bhntfp0u897r7nrfxjtwele1.jpeg', 3, 'có sẵn', 'Mở đầu cuốn sách Đông Kinh Nghĩa Thục Nguyễn Hiến Lê có viết: Mà có bao giờ người ta nghĩ tới cái việc thu thập tài liệu trong dân gian không? Chẳng hạn khi một danh nhân trong nước qua đời, phái một người tìm thân nhân hoặc bạn bè người mất để gom góp hoặc ghi chép những bút tích cùng dật sự về vị ấy, rồi đem về giữ trong các thư khố làm tài liệu cho đời sau. Công việc có khó khăn tốn kém gì đâu, mà lợi cho văn hóa biết bao.\r\nVới  những suy nghĩ đó mà có cái để người đời sau biết đến người hiền tài. Bởi lẽ vậy nên cụ Nguyễn Hiến Lê không chỉ viết về nhiều vị danh nhân trên khắp thế giới mà còn dành chút thời gian viết về mình với  tác phẩm Hồi Ký Nguyễn Hiến Lê bàn về Cuộc đời và tác phẩm của cụ. Cuốn sách được Bizbooks xuất bản như một lời tri ân đến cụ Nguyến Hiến Lê, gia đình, bạn bè, cộng đồng yêu mến cụ.', 'Nguyễn Hiến Lê', ' Cửa hàng Artbook', 'NXB Hội Nhà Văn', 0.00),
(45, 'Bài Học Về Sự Hy Sinh', 30000, '789ftvrcsz7b36v1lr7668bcx5wcfo3q.jpg', 1, 'có sẵn', 'Cuốn sách tập hợp những câu chuyện kể mang tính giáo dục về sự hy sinh, thể hiện tình yêu thương đối với mọi người xung quanh: Sự hy sinh cao cả; Tha thứ mãi mãi; Người mẹ thực vật; Vết sẹo...', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(46, 'Chân dung Ngô Tất Tố', 32000, '4cq1riyvijw31xf6jx1qh0dux6kujg69.jpeg', 1, 'có sẵn', 'Ngô Tất Tố là một trong những cây bút tiêu biểu của dòng văn học hiện thực phê phán những năm 30, 40 của thế kỉ XX. Ngô Tất Tố không chỉ là nhà viết tiểu thuyết, phóng sự, ông còn là một nhà báo cự phách, một nhà khảo cứu dịch thuật có tài, một nhà văn hóa lớn của dân tộc. Thành công của Ngô Tất Tố là thành công của quan điểm nghệ thuật vị nhân sinh, của một người cầm bút tự thấy phải hoạt động, phải xông pha, phải lăn lộn với cuộc sống nhân sinh. Ông luôn khiến mọi người nể trọng bởi bút lực dồi dào, bởi tinh thần “phản tỉnh” bản thân và xã hội một cách sâu sắc, tinh tế trong bất cứ lĩnh vực văn chương nào', 'Cao Đắc Điểm', 'NXB Thông tin và Truyền thông', 'NXB Thông tin và Truyền thông', 0.00),
(48, 'Cà phê đợi một người', 40000, '6gqx0zdsipjsqgrbj0hzm80jq8zl85k1.jpeg', 2, 'có sẵn', 'Trạch Vu đang đợi một người con gái mà trước mặt người ấy anh không phải nguỵ trang.\r\nBách Giai đang đợi một người con trai mà cậu ấy không phải chịu áp lực lựa chọn.\r\nA Thác đang đợi một cô gái tốt biết cách trân trọng bản chất thuần phác của anh.\r\nCòn tôi giờ đang đi đến đoạn vĩ thanh của bài toán sắp xếp tổ hợp tình yêu này. Trong quán cà phê Đợi Một Người, bên những tách cà phê hương vị khác nhau, chúng tôi đều đang đợi lời giải cho bài toán trái tim mình.', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'SaiGon Book', 0.00),
(49, 'Am Mây Ngủ', 70000, 'Screenshot 2023-10-11 204413.png', 2, 'có sẵn', 'Truyện Am Mây Ngủ tuy nói về công chúa Huyền Trân nhưng ở đây hình ảnh công chúa Huyền Trân không thể tách rời ra khỏi hình ảnh của người tăng sĩ áo vải sống trên am Ngọa Vân núi Yên Tử. Người ấy là Trúc Lâm Đại sĩ, tổ thứ nhất của Thiền phái Trúc Lâm.', 'Nhất Hạnh', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(50, 'Trở về Eden', 56000, '8ekd72wlegsycfzhlao9q62rfah08f3x.jpeg', 2, 'có sẵn', 'Trở về Eden – cuốn tiểu thuyết tâm lý tình cảm đặc sắc của Rosalind Miles như một thước phim dài cuốn hút người đọc bởi kịch tính, lãng mạn và quyết liệt.\r\n\r\n\r\n\r\n    Stephany Harper được thừa hưởng gia tài khổng lồ của người cha để lại và thiên đường hoang dã Eden – nơi cô muốn xây dựng hạnh phúc thực sự với người chồng mà cô yêu say đắm là Grey Marsdan – một ngôi sao quần vợt hào hoa. Sự đố kỵ của Jilly – người bạn gái thân thiết nhất và ham muốn dục vọng trong con người Grey đã cộng hưởng trở thành tội ác man rợ đối với Stephany. Chính ở Eden, khi đã nằm trong hàm cá sấu, cô mới nhìn thấy bộ mặt thật của bạn thân và chồng cô.', 'Rosalind Miles', 'Thế Giới', 'Nhà xuất bản Văn Học', 0.00),
(56, 'Tôi là con mèo', 50000, '582.jpg', 1, 'có sẵn', 'Câu chuyện này được giới văn học Nhật Bản đánh giá là một trong những tác phẩm độc đáo để lại dấu ấn khó phai trong lòng người đọc.\r\n\r\nGiàu tính ngụ ngôn và không khó đọc, Tôi là con mèo là biên niên sử của một con mèo bị vứt bỏ, không được yêu thương và nó đi lang thang khắp nơi để quan sát bản chất của con người – từ những chuyện kịch tính của các nhà doanh nhân và giáo viên cho đến những góc khuất của những kẻ tu hành và những kẻ đứng đầu. Từ góc nhìn độc đáo này, tác giả Natsume Soseki đã cay đắng bình luận về những biến động xã hội thời Minh Trị sau khi hoàn thành xong khóa triết học Trung Quốc.', '夏目漱石', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(57, 'Bởi vì Winn', 46000, '579.jpg', 1, 'có sẵn', 'Vào một ngày mùa hè, Opal và cha cô bé, nhà thuyết giáo, chuyển đến Naomi, Florida. Opal đi đến siêu thị tên Winn-Dixie và đi ra với một con chó. Một con chó to, mình mẩy hôi hám, răng vàng ỉn nhưng hay cười. Cô bé đặt tên nó theo tên cửa hàng siêu thị Winn-Dixie. Nhờ có Winn-Dixie, cha Opal kể cho cô 10 điều về người mẹ đã mất, mỗi năm kể một điều.', 'Kate DiCamillo', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(58, 'Ngựa ô yêu dấu', 56000, '588.jpg', 1, 'có sẵn', 'Cuộc sống của một chú ngựa có thể tràn đầy yêu thương và sự dịu dàng, nhưng cũng có thể bị lấp đầy bởi sự hèn hạ và độc ác. Chú ngựa đen đã tìm hiểu về hai khía cạnh này trong câu chuyện kinh điển viết bởi Anna Sewel.', 'Anna Sewell', 'Thế Giới', 'Hội nhà văn', 0.00),
(60, 'Chuyện con mèo dạy hải âu bay (1996)', 99000, 'Sach-3-2599-1438056746.jpg', 1, 'có sẵn', 'Cuốn sách là câu chuyện về chú mèo tên Zorba nhận của một cô hải âu sắp qua đời một quả trứng với lời hứa danh dự: sẽ ấp trứng nở, nuôi hải âu con trưởng thành và dạy cho hải âu biết bay. Lời hứa danh dự của loài mèo trở thành một bài học lớn cho thiếu nhi - thủ tín và yêu thương vô điều kiện.', 'Luis Sepúlveda', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(62, 'Chuyện Despereaux (2003)', 97000, 'Sach-4-3700-1438056746.jpg', 1, 'có sẵn', 'Tác phẩm kể về một chú chuột có thân hình bé nhỏ ra đời với cái tên Nỗi Thất Vọng nhưng lại có tình yêu mãnh liệt với âm nhạc, ánh sáng và những câu chuyện cổ tích. Nhà văn Mỹ Kate DiCamillo đã đưa độc giả đến với một thế giới lãng mạn của công chúa, hiệp sĩ, của phiêu lưu mạo hiểm và trên hết là về lòng can đảm của một chú chuột đã dám trở nên khác biệt.', 'Kate DiCamillo', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(77, 'Thao Túng Tâm Lý', 118000, '8936066692298.jpg', 1, 'có sẵn', 'Trong cuốn “Thao túng tâm lý”, tác giả Shannon Thomas giới thiệu đến độc giả những hiểu biết liên quan đến thao túng tâm lý và lạm dụng tiềm ẩn.', 'Shannon Thomas, LCSW', 'Thế Giới', 'Thế Giới', 0.00),
(140, 'Cây Cam Ngọt Của Tôi', 34000, 'image_217480.jpg', 2, 'có sẵn', 'JOSÉ MAURO DE VASCONCELOS (1920-1984) là nhà văn người Brazil. Sinh ra trong một gia đình nghèo ở ngoại ô Rio de Janeiro, lớn lên ông phải làm đủ nghề để kiếm sống. Nhưng với tài kể chuyện thiên bẩm, trí nhớ phi thường, trí tưởng tượng tuyệt vời cùng vốn sống phong phú, José cảm thấy trong mình thôi thúc phải trở thành nhà văn nên đã bắt đầu sáng tác năm 22 tuổi. Tác phẩm nổi tiếng nhất của ông là tiểu thuyết mang màu sắc tự truyện Cây cam ngọt của tôi', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(141, 'Không Diệt Không Sinh Đừng Sợ Hãi', 35000, 'Screenshot 2023-09-30 121543.png', 4, 'có sẵn', 'Nhiều người trong chúng ta tin rằng cuộc đời của ta bắt đầu từ lúc chào đời và kết thúc khi ta chết. Chúng ta tin rằng chúng ta tới từ cái Không, nên khi chết chúng ta cũng không còn lại gì hết. Và chúng ta lo lắng vì sẽ trở thành hư vô.', 'Thích Nhất Hạnh', 'Thế Giới', 'Thế Giới', 0.00),
(142, 'Suối Nguồn ', 67000, '2021_06_08_15_55_10_1-390x510.jpg', 3, 'có sẵn', 'Suối nguồn (The Fountainhead) tiểu thuyết của Ayn Rand, tác giả có ảnh hưởng lớn nhất đến độc giả Mỹ trong thế kỷ 20. - Tác phẩm đã bán được 6 triệu bản trong hơn 60 năm qua kể từ khi xuất bản lần đầu (năm 1943). - Được dịch ra nhiều thứ tiếng và vẫn liên tục được tái bản hàng năm. - Một tiểu thuyết kinh điển cần đọc nay đã có mặt tại Việt Nam với bản dịch tiếng Việt. Xin trân trọng giới thiệu cùng quý độc giả.', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(143, 'Thần Hổ', 43000, '8935244877243.jpg', 3, 'có sẵn', '“Lấy óc khoa học mà xét đoán, thì chuyện kể lại sau đây là một câu chuyện hoang đường. Nhưng ai đã từng đọc hết pho Liêu trai và bộ Truyền kỳ mạn lục, ai đã từng ngụ cư dăm bảy tháng trên các miền nước độc rừng thiêng, người ấy đọc truyện này ắt hẳn lấy làm thú vị, cho tôi không phải cố ý đặt ra một tiểu thuyết hão huyền. Phàm các truyện quái dị, huyền hoặc, có tự xưa đến nay, truyện nào cũng phát nguyên ở một hiện trạng – mắt tác giả đã thấy hoặc tai tác giả đã nghe – cũng do sự thực mà ra.', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(144, 'Ai Hát Giữa Rừng Khuya', 43000, '8935244877236.jpg', 3, 'có sẵn', 'TchyA từng rất nổi danh bởi những vần thơ được gọt dũa điêu luyện, đầy thanh tao ý tứ, mang hơi hướng thơ Đường, và đặc biệt là tác giả của rất nhiều truyện truyền kỳ – kinh dị chịu ảnh hưởng phong cách liêu trai. Ông là một trong số không nhiều những nhà văn trước năm 1945 chuyên viết về thể loại văn chương này, được xem là “cha đẻ” của ma trành và thần hổ – những nhân vật tưởng như hoang đường kỳ dị mà rất đời, ám ảnh hàng chục thế hệ độc giả bấy lâu nay… “Ai hát giữa rừng khuya” là một tiểu thuyết kinh dị nổi bật của ông', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(145, 'Vàng Và Máu', 36000, '8935244877205.jpg', 3, 'có sẵn', '“Thuở nhỏ tôi theo học chữ Nho. Thầy đồ tôi là một người yêu văn, nhất là yêu tiểu thuyết. Tối đến, khi bọn trò chúng tôi đã học thuộc bài, thầy lại đem các truyện Tàu ra đọc và dịch sang quốc âm cho chúng tôi nghe.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(146, 'Bên Đường Thiên Lôi', 43008, '2023_01_07_10_29_11_1-390x510.jpg', 3, 'có sẵn', 'Thế Lữ là tác giả nhiều bộ tiểu thuyết trinh thám sớm nhất mà cũng đặc sắc nhất của lịch sử tiểu thuyết Việt Nam. Sự có mặt các tiểu thuyết trinh thám của ông đã làm phong phú kho tàng tiểu thuyết hiện đại nước ta, có thể so sánh với tác giả nổi danh Tây phương.\r\n\r\n“Bên đường Thiên lôi” là một tập truyện ngắn kinh dị pha lẫn trinh thám rất tiêu biểu cho phong cách của Thế Lữ. 12 truyện ngắn trong “Bên đường Thiên Lôi” là 12 câu chuyện khiến bạn rùng mình, sợ hãi nhưng cuốn hút đến mức không thể rời khỏi trang sách.', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(147, 'Nghệ Thuật Tư Duy Phản Biện', 340000, '8936066689922.jpg', 2, 'có sẵn', 'Tư duy phản biện là một phần trong cuộc sống hằng ngày, bạn cần nắm lấy và phát triển từ nó. Thực hiện nghiên cứu của bạn, tìm kiếm các nguồn thông tin tốt, đưa ra lập luận của bạn và cân nhắc phản bác, cân nhắc xem bạn có đưa ra giả định hay không và đừng vội vàng đưa ra quyết định nếu bạn không hài lòng với thông tin bạn thu thập được.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(148, 'Nhà Giả Kim', 43600, 'Screenshot 2023-10-03 122150.png', 2, 'có sẵn', 'Tất cả những trải nghiệm trong chuyến phiêu du theo đuổi vận mệnh của mình đã giúp Santiago thấu hiểu được ý nghĩa sâu xa nhất của hạnh phúc, hòa hợp với vũ trụ và con người. ', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(149, 'Đắc Nhân Tâm', 340000, 'dntttttuntitled.png', 2, 'có sẵn', 'Đắc nhân tâm của Dale Carnegie là quyển sách của mọi thời đại và một hiện tượng đáng kinh ngạc trong ngành xuất bản Hoa Kỳ. Trong suốt nhiều thập kỷ tiếp theo và cho đến tận bây giờ, tác phẩm này vẫn chiếm vị trí số một trong danh mục sách bán chạy nhất và trở thành một sự kiện có một không hai trong lịch sử ngành xuất bản thế giới và được đánh giá là một quyển sách có tầm ảnh hưởng nhất mọi thời đại.', 'Dale Carnegie', 'Thế Giới', 'Thế Giới', 0.00),
(150, 'Tuổi Trẻ Đáng Giá Bao Nhiêu', 42000, '2021_09_29_08_49_04_1-390x510.jpg', 2, 'có sẵn', '“Bạn hối tiếc vì không nắm bắt lấy một cơ hội nào đó, chẳng có ai phải mất ngủ.\r\n\r\nBạn trải qua những ngày tháng nhạt nhẽo với công việc bạn căm ghét, người ta chẳng hề bận lòng.\r\n\r\nBạn có chết mòn nơi xó tường với những ước mơ dang dở, đó không phải là việc của họ.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(151, 'Bí Quyết Để Đạt Được Ước Mơ', 780000, '2020_04_28_15_40_49_1-390x510.jpg', 2, 'có sẵn', 'Bí quyết để đạt được ước mơ sẽ giúp bạn nhận biết những rào cản khiến mình không thể đưa ra lời yêu cầu và từ đó giúp bạn xác định được những đề xuất và phương cách hiệu quả để vượt qua chúng. Với nhiều câu chuyện thú vị và sâu sắc của những con người đã đạt được thành công bằng việc nêu lên yêu cầu, cuốn sách này sẽ mang đến cho bạn cách thay đổi cuộc sống – bất kể bạn đang gặp phải trở ngại nào. Và nhờ đó, bạn sẽ có được một cuộc sống như mong đợi – một kho báu không phải từ cây đèn thần mà xuất phát từ chính trái tim bạn.', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(152, 'Tết Ở Làng Địa Ngục', 457000, '2023_11_27_16_34_04_1-390x510.jpg', 2, 'có sẵn', 'Ngôi làng ấy vốn dĩ không có tên, nhưng những người nơi đây mặc định chốn này là địa ngục. Dân trong làng không ai dám tự ý băng rừng thoát khỏi làng, càng không biết thế giới bên ngoài rộng lớn như thế nào, bởi lẽ họ sợ người khác sẽ biết rằng bản thân mình vốn là hậu duệ của băng cướp khét tiếng ở truông nhà Hồ dưới thời chúa Nguyễn ở Đàng Trong.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(153, 'Tâm Trạng Trở Thành Thái Độ', 35000, 'b_a-1---_ng-_-t_m-tr_ng-tr_-th_nh-th_i-_.jpg', 2, 'có sẵn', 'ỗi chúng ta ai cũng từng trăn trở tại sao lại khó yêu thương chính mình đến vậy. Nhưng thời gian sẽ khiến bạn nhận ra đây là việc không ai có thể làm thay ngoài bản thân mình.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(154, 'Sống Cuộc Đời Do Mình Làm Chủ', 57000, 'gt_s_ng-cu_c-_i-do-m_nh-l_m-ch_bia-1.jpg', 4, 'có sẵn', 'Han Sung Hee, tác giả của cuốn sách, là một nhà phân tích tâm lý học và bác sĩ tâm thần trẻ em. Bà lấy bằng tiến sĩ y khoa và đã điều trị bệnh nhân tại Bệnh viện Quốc gia Seoul (nay là Trung tâm Sức khỏe Tâm thần Quốc gia) trong hơn 20 năm. Hiện bà đang là Giám đốc Khoa Tâm Thần, Han Lee.', 'Don Gabor', 'Thế Giới', 'Thế Giới', 0.00),
(155, 'Hãy Sống Từng Ngày Trọn Vẹn', 468000, '2021_02_25_16_27_34_1-390x510.jpg', 4, 'có sẵn', '\"HÃY SỐNG TỪNG NGÀY TRỌN VẸN\" là cuốn nhật ký sinh mệnh của Vu Quyên - một người mẹ, người vợ, người phụ nữ đang ở đỉnh cao của nhan sắc và trí tuệ, một giảng viên trẻ tuổi đã có bằng tiến sĩ của trường Đại học Phúc Đán (Thượng Hải).', 'Nguyên Anh', 'Thế Giới', 'Thế Giới', 0.00),
(156, 'Sống Cuộc Đời Bạn Muốn', 82000, '2021_04_16_09_16_22_1-390x510.jpg', 4, 'có sẵn', 'Khi được hỏi về việc tại sao không xuất bản sách thường xuyên, Glennon Doyle trả lời rằng: Cô sẽ không bao giờ viết một cuốn sách mới cho đến khi trở thành một người phụ nữ mới. Trong vài năm qua, Glennon Doyle đã trở thành một người phụ nữ mới, vậy nên Untamed - Sống cuộc đời bạn muốn là quyển sách kể về câu chuyện đó.', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(157, ' Bố Cho Con Cái Gì?', 543000, '2023_06_07_10_47_55_1-390x510.jpg', 4, 'có sẵn', 'Hôm nay bạn có vui không? Bạn vừa đi làm về, vừa tan học hay đang tranh thủ nghỉ ngơi chút xíu giữa cánh rừng deadlines? Tôi hi vọng khi bạn cầm cuốn sách này trên tay, giống như đang nghe “một người kể chuyện” kể về cuộc sống thường ngày, về tình yêu và nỗi nhớ chưa bao giờ dứt với cha mẹ, và những tháng năm tuổi trẻ gian khó nhưng vô cùng tươi đẹp, về những thứ bình dị diễn ra ngay trong cuộc sống của chúng ta mỗi ngà', 'Cao Minh', 'Thế Giới', 'Thế Giới', 0.00),
(158, 'Món Quà Cuộc Sống', 45400, 'monquacuocsong_50k_1.jpg', 4, 'có sẵn', 'Nếu bạn được tặng một vật đắt tiền như chiếc xe hơi hay trang sức gắn đá quý, bạn sẽ chăm chút món đồ đó như thế nào? Câu trả lời rất rõ ràng là bạn sẽ trân trọng và bảo quản món đồ thật cẩn thận. Vậy nếu cuộc đời của bạn cũng là một món quà, bạn nghĩ mình có đang quan tâm chăm sóc cuộc đời mình nhiều hơn của cải vật chất mình sở hữu không?', 'Nguyên Phong', 'Thế Giới', 'Thế Giới', 0.00),
(159, 'Cho Đi Là Còn Mãi', 658000, '2021_04_22_16_41_02_1-390x510.jpg', 4, 'có sẵn', 'Cuộc sống là quá trình trao tặng và đón nhận không ngừng, mỗi người chúng ta là một mắc xích quan trọng trong vòng liên kết ấy. Vì vậy, đừng do dự khi mở rộng lòng mình với mọi người. Rất nhiều người, nhiều nơi trên thế giới đang chờ đợi ở bạn một sự hảo tâm, một vòng tay ấm áp. Đôi khi, chỉ một ánh mắt trìu mến, một nụ cười thân thiện, hay một câu nói chân tình cũng đủ làm viên mãn một trái tim! Hãy cho đi để thấy rằng đời sống thật phong phú.', 'HUỲNH THÁI NGỌC', 'Thế Giới', 'Thế Giới', 0.00),
(160, ' Hãy Khiến Tương Lai Biết Ơn', 24000, '2021_05_10_08_57_22_1-390x510.jpg', 4, 'có sẵn', 'Với sự nghiệp: Bạn hiểu rằng không ai cả đời thuận buồm xuôi gió, mỗi người ít nhiều đều gặp phải khó khăn trắc trở, việc bạn cần làm - là không đổ lỗi cho ngoại cảnh mà âm thầm nâng cao năng lực và rút ra bài học cho bản thân', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user',
  `phone` int(14) NOT NULL,
  `location` varchar(500) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `token` varchar(500) NOT NULL,
  `status` enum('active','blocked') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `phone`, `location`, `avatar`, `token`, `status`) VALUES
(83, 'dat', 'Datboyngeo@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', 0, '', '', '', 'active'),
(85, 'Trieu Tien Dat (FPL HCM)', 'datttps31485@fpt.edu.vn', '', 'user', 354411541, 'tanphu1, di linh, dinh lac, lam dong ', 'IMG_6582.JPG', '', 'active'),
(87, 'dat', 'tiendat220404@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', 0, '', '', '', 'active'),
(88, 'tondeptrai', 'toandeptrai123@gmail.com', '202cb962ac59075b964b07152d234b70', 'user', 0, '', '', '', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cart_ibfk_1` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_ibfk_2` (`product_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_detail_ibfk_1` (`order_id`),
  ADD KEY `order_detail_ibfk_2` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_ibfk_1` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=489;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=450;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=269;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
