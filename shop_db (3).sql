-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2023 at 10:40 AM
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
(1, 'dongvat'),
(2, 'tamly'),
(3, 'kinhdi'),
(4, 'doisong');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `message` varchar(200) NOT NULL,
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

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(11) NOT NULL,
  `placed_on` varchar(50) NOT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Đợi xác nhận',
  `order_code` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `order_code`) VALUES
(299, 75, 'thanh toán khi nhận hàng', '256/1/6 dương quảng hàm, HỒ CHÍ MINH, Vietnam', '25 nhân vật lịch sử (4) , Nghệ thuật xếp giấy Nhật Bản (5) ', 266000, '30/11/2023', 'Đã hủy', 'ORDER17013201801855'),
(300, 75, 'thanh toán khi nhận hàng', '256/1/6 dương quảng hàm, 13000, Vietnam', 'Hạnh phúc và những điều nhỏ bé quan trọng khác (2) ', 46000, '30-Nov-2023', 'Đã hủy', 'ORDER17013206904270'),
(301, 75, 'thanh toán khi nhận hàng', '256/1/6 dương quảng hàm, HỒ CHÍ MINH, Vietnam', 'Nghệ thuật xếp giấy Nhật Bản (1) ', 42000, '30/11/2023', 'Đã hủy', 'ORDER17013232463778');

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
(129, 4, 299, 38, 56000),
(130, 5, 299, 33, 210000),
(131, 2, 300, 31, 46000),
(132, 1, 301, 33, 42000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `in4` varchar(1000) NOT NULL,
  `tacgia` varchar(100) NOT NULL,
  `nhacungcap` varchar(100) NOT NULL,
  `nhaxuatban` varchar(100) NOT NULL,
  `discount` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `in4`, `tacgia`, `nhacungcap`, `nhaxuatban`, `discount`) VALUES
(30, '  Tu Giữa Đời Thường', 63000, 'ktwgm07agf23g4cruela6ppdpaaqkbvn.jpg', 4, 'Thế giới hiện đại, đặc biệt là nhịp sống hối hả của môi trường đô thị khiến con người ngày càng mất kết nối với tự nhiên, rời xa bản chất đích thực để chạy theo các khuôn mẫu bên ngoài. Khủng hoảng của con người đô thị hiện đại diễn ra ở hầu hết các khía cạnh đời sống, khiến chúng ta kiệt sức, thiếu thời gian, rơi vào lối sống trì trệ, chán ghét bản thân và không tìm thấy ý nghĩa sống.', 'Pedram Shojai', 'Thế Giới', 'Cornerstone', 0.00),
(31, 'Hạnh phúc và những điều nhỏ bé quan trọng khác', 23000, 'Screenshot 2023-10-11 190243.png', 2, 'Dựa trên nguồn tư liệu văn học và triết học đồ sộ , từ Alice ở xứ sở thần tiên, Hoàng tử bé dến Lev Tolstory ,King Solomon và Friedrich Nietzshce ,Haim Shapira đã thách thức những quan niệm xưa cũ về hạnh phúc của độc giả, giúp chúng ta biết trân trọng những điều nhỏ bé nhưng có tầm quan trọng lớn lao trên hành trình của đời sống.Nếu như ý định khiến con người \"\"hạnh phúc\"\" không nằm trong kế hoạch của \"\"Đấng sáng thế\"\" con người chúng ta cần làm gì để có một cuộc đời đáng sống với những phút giây của niềm vui thực sự?\"', 'Marie Tourell Søderberg', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(32, ' The Magic of Thinking Big', 70000, 'ol7jnr0zrkv1s0cins0hb38qihu9s5yi.jpeg', 4, '    Hãy thử nghĩ về những người có mức thu nhập cao hơn bạn gấp 5 lần. Có phải họ thông minh hơn bạn gấp 5 lần? Họ làm việc vất vả hơn bạn gấp 5 lần? Nếu câu trả lời của bạn là “không” thì bạn sẽ chạm đến câu hỏi này: “Vậy, họ có những đức tính, phẩm chất hay bí quyết gì mà tôi không có?”', 'David J Schwartz ', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(33, 'Nghệ thuật xếp giấy Nhật Bản', 42000, 'uzpitr0xfwwbmbv2q6bchn21lpz3n4l8.jpeg', 4, '  Bạn biết không, chỉ cần những mẩu giấy có kích cỡ cần thiết thôi là bạn đã có thể xếp được theo ý muốn khá nhiều hình ảnh khác nhau. Yêu cầu của trò chơi xếp giấy này sẽ rèn luyện cho bạn biết cách nhìn hình mẫu thật kỹ, nắm bắt được những kỹ thuật xếp, gấp để có thể tạo ra những mẫu gấp hình thật đẹp.', '‎Snippet view', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(34, '  Giao tiếp bất kỳ ai', 5000, '7k27z4yvxtqmqijapg7yioa36a6qjjzu.jpeg', 4, 'Một doanh nghiệp thành công hay thất bại thường tùy thuộc vào những kỹ năng giao tiếp nhiều hơn là phát triển kỹ thuật. Cuốn sách tuyệt vời này giúp bạn nâng cao các kỹ năng giao tiếp như nghe và nói trên mọi phương diện; với cả những yếu tố khác như: ngôn ngữ cơ thể, hành vi ứng xử và thái độ… giúp bạn có thể chinh phục được khách hàng, nhà cung cấp và tất cả những người liên quan tới bạn. Jo và Bennie thừa đủ tư cách để giúp bạn phát triển mạnh mẽ doanh nghiệp của mình.', 'Jo Condrill', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(36, 'Năng lực sống sót trong kỷ nguyên mới', 54000, 'bg601exq741gxydcmsen90il8742psl2.jpeg', 4, 'BQ – Năng lực sống sót trong kỷ nguyên mới\r\nKhi xã hội thay đổi cấu trúc và sự cạnh tranh ngày càng gay gắt, lực lượng lao động theo tư duy cũ sẽ bị đào thải.\r\nKhông có vùng an toàn.\r\nTất cả chúng ta, dù muốn hay không, đều bị nhấn chìm trong vòng xoáy của cuộc chơi chọn lọc đó.\r\nVậy, những nhân viên như thế nào sẽ tồn tại được?  \r\nChìa khóa chính là “Chỉ số thông minh kinh doanh – BQ”, một chỉ số đã được thế giới công nhận là bí quyết để đổi mới.', 'Alan Greenspan', 'Thế Giới', 'SaiGon Book', 0.00),
(37, 'Sống sót sau những cú shock kinh doanh', 40000, 'Screenshot 2023-10-11 191429.png', 3, 'Theo các chuyên gia tài chính, do ảnh hưởng của dịch COVID-19, trong 7 tháng năm 2021, gần 80.000 doanh nghiệp đã phải rời bỏ thị trường. Từ nay đến hết năm, nếu Việt Nam có thể kiểm soát được dịch bệnh và phục hồi kinh tế, số lượng doanh nghiệp phá sản cũng ở mức 100.000. Hiện mỗi tháng có khoảng 10.000 doanh nghiệp phá sản. Trường hợp nếu không kiểm soát được dịch bệnh, sẽ có khoảng 150.000 doanh nghiệp phá sản trong năm nay.', 'Sergio Bitar', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(38, '25 nhân vật lịch sử', 14000, 'qt3td7387xa8elp6gdzmnpda216dzbf6.jpeg', 3, 'Lịch sử của cả quốc gia lẫn cá nhân đều không tồn tại chữ “nếu”!\r\n\r\n\r\n\r\n    Tuy nhiên, việc suy ngẫm về từng thời điểm nào đó và đặt ra những giả thuyết “nếu…thì…” thật thú vị!\r\n\r\n\r\n\r\n    Ở trường học sinh sợ học môn lịch sử một phần là vì khi học các em có rất ít cơ hội, không gian và điều kiện đảm bảo để có thể tưởng tượng “nếu…thì…” hoặc suy ngẫm về các biến cố của quốc gia hoặc cuộc đời của các cá nhân ở nhiều góc độ khác nhau.\r\n\r\n\r\n\r\n    Lịch sử vì thế trở thành một thứ “lịch sử vô nhân xưng”, dễ rơi vào chung chung và trừu tượng. Để bù đắp nhược điểm cố hữu đó của môn lịch sử trong trường học (không chỉ là ở Việt Nam), học sinh cần đọc các sách về lịch sử ở bên ngoài.', 'Nguyễn Quốc Vương', 'Phụ nữ việt nam', 'Phụ nữ việt nam', 0.00),
(39, 'SỨC MẠNH CỦA NHỮNG VẾT THƯƠNG', 21000, 'emw2aln2tkc9yi8fk0g6oi9bp1h7bmi8.jpeg', 3, '“Sức mạnh của vết thương” là tập tiểu luận phê bình mới nhất của nhà lý luận phê bình\r\nHoàng Thụy Anh được phát hành đầu năm nay. Hoàng Thụy Anh được biết đến là một nhà phê bình tài năng với nhiều thành tựu ấn tượng. Tác giả không ngừng tìm hiểu và phân tích phê bình ở nhiều thể loại văn chương khác nhau. Trong “Sức mạnh của vết thương”, Hoàng Thụy Anh đã phân tích nhiều tác phẩm có thể loại sáng tác khác nhau. Nhưng đều nói đến một chủ đề là thân phận người phụ nữ và “vết thương\" của họ. ', 'Hoàng Thụy Anh', ' Cửa hàng Artbook', 'NXB Hội Nhà Văn', 0.00),
(40, 'Thành Cát Tư Hãn là ai?', 25000, 'Screenshot 2023-10-11 192607.png', 3, 'Hãy cùng đọc bộ sách “Là ai? - Chân dung những người làm thay đổi thế giới\" để hiểu được những thăng trầm, những biến cố, những thành công trong cuộc đời của mỗi thiên tài. Từng câu, từng chữ miêu tả một cách chân thực nhất nội tâm cảm xúc nhân vật cũng những hình ảnh minh họa sống động giúp cho bất kỳ ai cũng có cảm nhận như chúng ta đang được chính những vị danh nhân ấy kể chuyện cho nghe vậy.', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(41, 'Bán đảo Ả rập', 27000, 'Screenshot 2023-10-11 192847.png', 3, 'Bán đảo Ả rập là đế quốc của Hồi giáo gồm 7 quốc gia: Ai cập, Syrie, Liban, Jorrdanie, Irak, Ả Rập Sesoudite, Yeman, mà cũng là đế quốc của dầu lửa, vì dầu lửa chi phối nó cũng như Hồi giáo, còn mạnh hơn Hồi giáo. Hồi giáo liên kết Ả Rập thì Dầu lửa chia rẽ Ả Rập. Và vậy mà ba bốn chục năm nay ở bán đảo Ả Rập xảy ra không biết bao nhiêu xung đột: xung đột giữa các đế quốc, xung đột giữa các quốc gia Ả Rập, xung đột giữa các đảng phái trong mỗi quốc gia... ', 'Amy Newmark', ' Cửa hàng Artbook', 'NXB Hội Nhà Văn', 0.00),
(42, 'Hồi ký Nguyễn Hiến Lê', 28000, 'jpr71l14bhntfp0u897r7nrfxjtwele1.jpeg', 3, 'Mở đầu cuốn sách Đông Kinh Nghĩa Thục Nguyễn Hiến Lê có viết: Mà có bao giờ người ta nghĩ tới cái việc thu thập tài liệu trong dân gian không? Chẳng hạn khi một danh nhân trong nước qua đời, phái một người tìm thân nhân hoặc bạn bè người mất để gom góp hoặc ghi chép những bút tích cùng dật sự về vị ấy, rồi đem về giữ trong các thư khố làm tài liệu cho đời sau. Công việc có khó khăn tốn kém gì đâu, mà lợi cho văn hóa biết bao.\r\nVới  những suy nghĩ đó mà có cái để người đời sau biết đến người hiền tài. Bởi lẽ vậy nên cụ Nguyễn Hiến Lê không chỉ viết về nhiều vị danh nhân trên khắp thế giới mà còn dành chút thời gian viết về mình với  tác phẩm Hồi Ký Nguyễn Hiến Lê bàn về Cuộc đời và tác phẩm của cụ. Cuốn sách được Bizbooks xuất bản như một lời tri ân đến cụ Nguyến Hiến Lê, gia đình, bạn bè, cộng đồng yêu mến cụ.', 'Nguyễn Hiến Lê', ' Cửa hàng Artbook', 'NXB Hội Nhà Văn', 0.00),
(44, 'Chúng Tôi Cần Bạn', 40000, 'd5er9onm9xzx9unoiv0c098321qxyf32.jpg', 1, 'Cuộc sống là một hành trình dài với vô số biến cố và thử thách đòi hỏi chúng ta phải vượt qua, nhưng cuộc sống không phải là cái bẫy để chờ chúng ta sa vào rồi phán xét, mà những biến cố, thử thách đó sẽ giúp chúng ta trưởng thành hơn bằng những bài học sâu sắc đằng sau nó. Vậy chúng ta học được gì từ cuộc sống? Có lẽ là rất nhiều, nhưng có những bài học mà chúng ta sẽ không thể nào bỏ qua:\r\nBài học về sự quan tâm: Trong cuộc sống ai cũng cần sự quan tâm, yêu thương và chia sẻ. Quan tâm tới một người không đơn giản chỉ là việc xem người ấy sống thế nào, cuộc sống có đầy đủ hay không.', 'Kate DiCamillo', 'Thế Giới', 'SaiGon Book', 0.00),
(45, 'Bài Học Về Sự Hy Sinh', 30000, '789ftvrcsz7b36v1lr7668bcx5wcfo3q.jpg', 1, 'Cuốn sách tập hợp những câu chuyện kể mang tính giáo dục về sự hy sinh, thể hiện tình yêu thương đối với mọi người xung quanh: Sự hy sinh cao cả; Tha thứ mãi mãi; Người mẹ thực vật; Vết sẹo...', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(46, 'Chân dung Ngô Tất Tố', 32000, '4cq1riyvijw31xf6jx1qh0dux6kujg69.jpeg', 1, 'Ngô Tất Tố là một trong những cây bút tiêu biểu của dòng văn học hiện thực phê phán những năm 30, 40 của thế kỉ XX. Ngô Tất Tố không chỉ là nhà viết tiểu thuyết, phóng sự, ông còn là một nhà báo cự phách, một nhà khảo cứu dịch thuật có tài, một nhà văn hóa lớn của dân tộc. Thành công của Ngô Tất Tố là thành công của quan điểm nghệ thuật vị nhân sinh, của một người cầm bút tự thấy phải hoạt động, phải xông pha, phải lăn lộn với cuộc sống nhân sinh. Ông luôn khiến mọi người nể trọng bởi bút lực dồi dào, bởi tinh thần “phản tỉnh” bản thân và xã hội một cách sâu sắc, tinh tế trong bất cứ lĩnh vực văn chương nào', 'Cao Đắc Điểm', 'NXB Thông tin và Truyền thông', 'NXB Thông tin và Truyền thông', 0.00),
(47, 'Những nỗi buồn ở chế độ lặng im', 50000, 'wte2chfq03gi9qukzzan8gu6jv5hirtg.jpeg', 3, 'Cuốn sách “Những nỗi buồn ở chế độ lặng im” – tác phẩm đầu tay của tác giả trẻ đầy tài năng Per sẽ cùng bạn đi qua từng chặng đường của thanh xuân. Bằng những vần thơ giản dị, gần gũi tác giả đưa chúng ta trải qua từng cảm xúc trên hành trình trưởng thành.', 'Per', 'Phụ Nữ Việt Nam', 'Phụ Nữ Việt Nam', 0.00),
(48, 'Cà phê đợi một người', 40000, '6gqx0zdsipjsqgrbj0hzm80jq8zl85k1.jpeg', 2, 'Trạch Vu đang đợi một người con gái mà trước mặt người ấy anh không phải nguỵ trang.\r\nBách Giai đang đợi một người con trai mà cậu ấy không phải chịu áp lực lựa chọn.\r\nA Thác đang đợi một cô gái tốt biết cách trân trọng bản chất thuần phác của anh.\r\nCòn tôi giờ đang đi đến đoạn vĩ thanh của bài toán sắp xếp tổ hợp tình yêu này. Trong quán cà phê Đợi Một Người, bên những tách cà phê hương vị khác nhau, chúng tôi đều đang đợi lời giải cho bài toán trái tim mình.', 'Nguyễn Hoàng Nguyên', 'Thế Giới', 'SaiGon Book', 0.00),
(49, 'Am Mây Ngủ', 70000, 'Screenshot 2023-10-11 204413.png', 2, 'Truyện Am Mây Ngủ tuy nói về công chúa Huyền Trân nhưng ở đây hình ảnh công chúa Huyền Trân không thể tách rời ra khỏi hình ảnh của người tăng sĩ áo vải sống trên am Ngọa Vân núi Yên Tử. Người ấy là Trúc Lâm Đại sĩ, tổ thứ nhất của Thiền phái Trúc Lâm.', 'Nhất Hạnh', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(50, 'Trở về Eden', 56000, '8ekd72wlegsycfzhlao9q62rfah08f3x.jpeg', 2, 'Trở về Eden – cuốn tiểu thuyết tâm lý tình cảm đặc sắc của Rosalind Miles như một thước phim dài cuốn hút người đọc bởi kịch tính, lãng mạn và quyết liệt.\r\n\r\n\r\n\r\n    Stephany Harper được thừa hưởng gia tài khổng lồ của người cha để lại và thiên đường hoang dã Eden – nơi cô muốn xây dựng hạnh phúc thực sự với người chồng mà cô yêu say đắm là Grey Marsdan – một ngôi sao quần vợt hào hoa. Sự đố kỵ của Jilly – người bạn gái thân thiết nhất và ham muốn dục vọng trong con người Grey đã cộng hưởng trở thành tội ác man rợ đối với Stephany. Chính ở Eden, khi đã nằm trong hàm cá sấu, cô mới nhìn thấy bộ mặt thật của bạn thân và chồng cô.', 'Rosalind Miles', 'Thế Giới', 'Nhà xuất bản Văn Học', 0.00),
(51, 'Yêu, Dại Dột, Yêu', 65000, 'ejr4k5ibfzbrc8wlmx7ocr1zy3e06r4r.jpeg', 2, 'Không có thông tin', 'Ý Yên Phan', 'Thế Giới', 'Nhà xuất bản Phụ nữ', 0.00),
(52, 'Tựa Lưng Vào Nỗi Nhớ', 50000, 'sgbim8wi58undq6j0035x3vv1sao6d3o.jpeg', 2, 'Không có thông tin', 'Hồng Phúc Dương', 'Thế Giới', 'Nhà xuất bản văn hóa - văn nghệ TP.HCM', 0.00),
(53, 'Dế mèn phiêu lưu ký (1941)', 190000, 'Sach-6-6245-1438056744.jpg', 1, 'Ấn bản đầu tiên vào năm 1941 của cuốn sách này có tên là Con dế mèn, chỉ gồm ba chương đầu tiên. Khi được độc giả đón nhận nồng nhiệt, tác giả Tô Hoài bắt tay viết thêm những chương sau để ra mắt một tác phẩm hoàn chỉnh có tên Dế mèn phiêu lưu ký. Từ đó, cuốn sách ghi dấu ấn tuổi thơ của biết bao thế hệ người Việt Nam. Câu chuyện là quá trình lớn lên, trưởng thành và dấn thân vào chuyến phiêu lưu khám phá thế giới rộng lớn của một chú dế rất bé nhỏ nhưng rất mạnh mẽ.', 'Tô Hoài', ' Cửa hàng Artbook', 'Nhà xuất bản Tân Dân', 0.00),
(55, 'Cuộc phiêu lưu của Văn Ngan tướng công (1986)', 38000, 'van-ngan-tuong-quan-1-9743-1438056745.jpg', 1, 'Đây là tác phẩm ghi lại cuộc phiêu lưu của một chú Ngan với những câu chuyện buồn vui thăng trầm trên bước đường viễn du. Với cách viết giản dị, pha trộn giữa chất hiện thực và đồng thoại, quyển sách mở ra một cái nhìn chân thực mà không kém phần mộng mơ về thế giới. Giọng văn dí dỏm, hài hước của tác giả Vũ Tú Nam đưa Văn Ngan tướng công trở thành một nhân vật điển hình của tuổi thơ của rất nhiều độc giả Việt Nam.', 'Vũ Tú Nam', 'Thế Giới', 'Kim Đồng', 0.00),
(56, 'Tôi là con mèo', 50000, '582.jpg', 1, 'Câu chuyện này được giới văn học Nhật Bản đánh giá là một trong những tác phẩm độc đáo để lại dấu ấn khó phai trong lòng người đọc.\r\n\r\nGiàu tính ngụ ngôn và không khó đọc, Tôi là con mèo là biên niên sử của một con mèo bị vứt bỏ, không được yêu thương và nó đi lang thang khắp nơi để quan sát bản chất của con người – từ những chuyện kịch tính của các nhà doanh nhân và giáo viên cho đến những góc khuất của những kẻ tu hành và những kẻ đứng đầu. Từ góc nhìn độc đáo này, tác giả Natsume Soseki đã cay đắng bình luận về những biến động xã hội thời Minh Trị sau khi hoàn thành xong khóa triết học Trung Quốc.', '夏目漱石', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(57, 'Bởi vì Winn', 46000, '579.jpg', 1, 'Vào một ngày mùa hè, Opal và cha cô bé, nhà thuyết giáo, chuyển đến Naomi, Florida. Opal đi đến siêu thị tên Winn-Dixie và đi ra với một con chó. Một con chó to, mình mẩy hôi hám, răng vàng ỉn nhưng hay cười. Cô bé đặt tên nó theo tên cửa hàng siêu thị Winn-Dixie. Nhờ có Winn-Dixie, cha Opal kể cho cô 10 điều về người mẹ đã mất, mỗi năm kể một điều.', 'Kate DiCamillo', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(58, 'Ngựa ô yêu dấu', 56000, '588.jpg', 1, 'Cuộc sống của một chú ngựa có thể tràn đầy yêu thương và sự dịu dàng, nhưng cũng có thể bị lấp đầy bởi sự hèn hạ và độc ác. Chú ngựa đen đã tìm hiểu về hai khía cạnh này trong câu chuyện kinh điển viết bởi Anna Sewel.', 'Anna Sewell', 'Thế Giới', 'Hội nhà văn', 0.00),
(60, 'Chuyện con mèo dạy hải âu bay (1996)', 99000, 'Sach-3-2599-1438056746.jpg', 1, 'Cuốn sách là câu chuyện về chú mèo tên Zorba nhận của một cô hải âu sắp qua đời một quả trứng với lời hứa danh dự: sẽ ấp trứng nở, nuôi hải âu con trưởng thành và dạy cho hải âu biết bay. Lời hứa danh dự của loài mèo trở thành một bài học lớn cho thiếu nhi - thủ tín và yêu thương vô điều kiện.', 'Luis Sepúlveda', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(61, 'Cô gà mái xổng chuồng (2000)', 56000, 'Sach-5-8672-1438056746.jpg', 1, 'Cô gà mái tự đặt cho mình cái tên Mầm Lá là cô gà mái đặc biệt trong chuồng, không chỉ biết cúi đầu ăn mà còn biết ngắm những tán cây ngoài lưới sắt. Không chấp nhận cuộc sống quẩn quanh chỉ biết ăn và đẻ trứng, cô nuôi ý định vượt rào đến với thế giới bên ngoài.', 'Hwang Sun-mi', 'Thế Giới', 'SaiGon Book', 0.00),
(62, 'Chuyện Despereaux (2003)', 97000, 'Sach-4-3700-1438056746.jpg', 1, 'Tác phẩm kể về một chú chuột có thân hình bé nhỏ ra đời với cái tên Nỗi Thất Vọng nhưng lại có tình yêu mãnh liệt với âm nhạc, ánh sáng và những câu chuyện cổ tích. Nhà văn Mỹ Kate DiCamillo đã đưa độc giả đến với một thế giới lãng mạn của công chúa, hiệp sĩ, của phiêu lưu mạo hiểm và trên hết là về lòng can đảm của một chú chuột đã dám trở nên khác biệt.', 'Kate DiCamillo', 'Thế Giới', 'NXB Hội Nhà Văn', 0.00),
(74, 'Không Diệt Không Sinh Đừng Sợ Hãi', 77000, '8935278607311.jpg', 1, 'Nhiều người trong chúng ta tin rằng cuộc đời của ta bắt đầu từ lúc chào đời và kết thúc khi ta chết. Chúng ta tin rằng chúng ta tới từ cái Không, nên khi chết chúng ta cũng không còn lại gì hết. Và chúng ta lo lắng vì sẽ trở thành hư vô.', 'Thích Nhất Hạnh', 'Thế Giới', 'Thế Giới', 0.00),
(75, 'Thay Đổi Cuộc Sống Với Nhân Số Học', 173000, 'tdcsvnsh.jpg', 1, 'Cuốn sách Thay đổi cuộc sống với Nhân số học là tác phẩm được chị Lê Đỗ Quỳnh Hương phát triển từ tác phẩm gốc “The Complete Book of Numerology” của tiến sỹ David A. Phillips, khiến bộ môn Nhân số học khởi nguồn từ nhà toán học Pythagoras trở nên gần gũi, dễ hiểu hơn với độc giả Việt Nam.', 'Lê Đỗ Quỳnh Hương', 'Thế Giới', 'Thế Giới', 0.00),
(76, 'Khéo Ăn Nói Sẽ Có Được Thiên Hạ ', 78000, '8936067605693.jpg', 1, 'Trong xã hội thông tin hiện đại, sự im lặng không còn là vàng nữa, nếu không biết cách giao tiếp thì dù là vàng cũng sẽ bị chôn vùi. Trong cuộc đời một con người, từ xin việc đến thăng tiến, từ tình yêu đến hôn nhân, từ tiếp thị cho đến đàm phán, từ xã giao đến làm việc… không thể không cần đến kĩ năng và khả năng giao tiếp. Khéo ăn khéo nói thì đi đâu, làm gì cũng gặp thuận lợi. Không khéo ăn nói, bốn bề đều là trở ngại khó khăn.', 'Trác Nhã', 'Thế Giới', 'Thế Giới', 0.00),
(77, 'Thao Túng Tâm Lý', 118000, '8936066692298.jpg', 1, 'Trong cuốn “Thao túng tâm lý”, tác giả Shannon Thomas giới thiệu đến độc giả những hiểu biết liên quan đến thao túng tâm lý và lạm dụng tiềm ẩn.', 'Shannon Thomas, LCSW', 'Thế Giới', 'Thế Giới', 0.00),
(78, 'Hành Tinh Của Một Kẻ Nghĩ Nhiều', 60000, 'h_nh-tinh-c_a-m_t-k_-ngh_-nhi_u-tr_c-1-1.jpg', 1, 'Hành tinh của một kẻ nghĩ nhiều là hành trình khám phá thế giới nội tâm của một người trẻ. Đó là một hành tinh đầy hỗn loạn của những suy nghĩ trăn trở, những dằn vặt, những cuộc chiến nội tâm, những cảm xúc vừa phức tạp cũng vừa rất đỗi con người. Một thế giới quen thuộc với tất cả chúng ta.', 'Amateur Psychology Nguyễn', 'Thế Giới', 'Thế Giới', 0.00),
(80, 'Thiên Tài Bên Trái, Kẻ Điên Bên Phải', 125000, 'b_a-thi_n-t_i-b_n-tr_i-k_-_i_n-b_n-ph_i_1.jpg', 1, 'Thiên tài bên trái, kẻ điên bên phải là cuốn sách dành cho những người điên rồ, những kẻ gây rối, những người chống đối, những mảnh ghép hình tròn trong những ô vuông không vừa vặn…', 'Cao Minh', 'Thế Giới', 'Thế Giới', 0.00);

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
  `token` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `phone`, `location`, `avatar`, `token`) VALUES
(4, 'deptrai', 'Datboyngeo@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', 0, '0', '', 'dc9ea59ad9690cfd0137b9d7cfb7822f0902d510423e1551ab08cbee3ea06ce1'),
(75, 'Trieu Tien Dat (FPL HCM)', 'datttps31485@fpt.edu.vn', '', 'user', 354411541, 'tanphu1, di linh, dinh lac, lam dong ', 'ABLK5171.JPEG', ''),
(76, 'Đạt Tiến', 'tiendat220404@gmail.com', '', 'user', 0, '', 'https://lh3.googleusercontent.com/a/ACg8ocKbVJMjBn1XqYKhg0u-FaTjtamw0SMdosAPPWhVJkR5-g=s96-c', ''),
(77, 'dat', 'yen542182@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user', 0, '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=331;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

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
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
