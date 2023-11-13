-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2023 at 10:04 AM
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

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `user_id`, `product_id`, `message`, `created_at`) VALUES
(45, 19, 10, 'test', '2023-11-09 13:24:49'),
(48, 19, 4, 'test', '2023-11-11 10:30:57');

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
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(20, 19, 'paypal', 'flat no. 123, 444, TP HCM, HỒ CHÍ MINH, Vietnam - 14000', 'darknet (1) ', 16, '09-Nov-2023', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `in4` varchar(1000) NOT NULL,
  `tacgia` varchar(100) NOT NULL,
  `nhacungcap` varchar(100) NOT NULL,
  `nhaxuatban` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`, `in4`, `tacgia`, `nhacungcap`, `nhaxuatban`) VALUES
(1, 'the world of art', 25, 'the_world.jpg', 1, '\r\nQuyển sách The World of Art của tác giả E.H. Gombrich là một cuốn sách bách khoa về lịch sử nghệ thuật phương Tây. Quyển sách được xuất bản lần đầu tiên vào năm 1950 và đã được tái bản nhiều lần.\r\n\r\nQuyển sách bắt đầu bằng việc giới thiệu về các nền văn minh cổ đại, bao gồm Ai Cập, Hy Lạp và La Mã. Gombrich sau đó đi sâu vào các phong trào nghệ thuật khác nhau, bao gồm Gothic, Phục hưng, Baroque, Rococo, Tân cổ điển, Lãng mạn, Hiện thực, Ấn tượng, Hậu ấn tượng, Xu hướng hiện đại và Hiện đại.\r\n\r\nGombrich kết thúc bằng một cuộc thảo luận về nghệ thuật đương đại. Ông lập luận rằng nghệ thuật là một quá trình sáng tạo liên tục, và nó không thể được hiểu chỉ bằng cách nhìn vào quá khứ.', '', '', ''),
(2, 'happy lemons', 10, 'the_happy_lemon.jpg', 4, 'Quyển sách Happy Lemons của tác giả Nguyễn Ngọc Thạch là một tiểu thuyết tình yêu, lãng mạn, hài hước. Quyển sách được xuất bản lần đầu tiên vào năm 2016.\r\n\r\nCâu chuyện kể về hai nhân vật chính là Linh và Huy, hai người bạn thân từ thời cấp ba. Linh là một cô gái xinh đẹp, thông minh và mạnh mẽ. Huy là một chàng trai hài hước, lãng mạn và ấm áp.\r\n\r\nSau khi tốt nghiệp đại học, Linh và Huy chia tay nhau vì những lý do khác nhau. Linh đi du học ở nước ngoài, còn Huy ở lại Việt Nam.\r\n\r\nBảy năm sau, Linh trở về Việt Nam và gặp lại Huy. Cả hai đều đã trưởng thành và thay đổi, nhưng tình cảm của họ vẫn còn nguyên vẹn.', 'Không', 'Thế Giới', 'SaiGon Book'),
(4, 'darknet', 16, 'darknet.jpg', 3, '\r\nQuyển sách Darknet của tác giả Jamie Bartlett là một cuốn sách phi hư cấu khám phá thế giới ngầm của internet. Quyển sách được xuất bản lần đầu tiên vào năm 2014 và đã được cập nhật hai lần, lần gần nhất là vào năm 2022.\r\n\r\nQuyển sách bắt đầu bằng việc giới thiệu về lịch sử và sự phát triển của darknet. Darknet là một phần của internet mà chỉ có thể truy cập được thông qua phần mềm đặc biệt. Nó được sử dụng cho nhiều mục đích khác nhau, bao gồm các hoạt động bất hợp pháp như mua bán ma túy và vũ khí, và các hoạt động hợp pháp như bảo vệ quyền riêng tư.\r\n\r\nBartlett sau đó dành phần lớn quyển sách để khám phá các hoạt động diễn ra trên darknet. Ông viết về các chợ đen, nơi người dùng có thể mua bán hàng hóa bất hợp pháp; các dịch vụ mã hóa, giúp người dùng ẩn danh trên internet; và các diễn đàn, nơi người dùng có thể chia sẻ thông tin và ý kiến.\r\n\r\nQuyển sách kết thúc bằng một cuộc thảo luận về tác động của darknet đối với xã hội. Bartlett lập luận rằng darknet có thể được sử dụng cho ', '', '', ''),
(6, 'bee well bee', 12, 'be_well_bee.jpg', 2, ' bee well bee thuộc dòng sách “Amazing Pop-Up Fun” đem đến những câu chuyện ngộ nghĩnh về các loài động vật đáng mến với minh họa pop-up 3D nổi bật. Đây là lựa chọn lý tưởng cho những câu chuyện kể trước giờ đi ngủ, đưa bé vào những giấc mộng đẹp đẽ và thú vị.', '', '', ''),
(7, 'red queen', 45, 'red_queen.jpg', 3, 'Đây là tập đầu của series Red Queen, best-seller trong nhiều tuần, rating trên goodreads cũng khá cao. Bối cảnh của cuốn sách là một tương lai khi con người chia thành hai chủng tộc, chủng tộc máu Bạc và chủng tộc máu Đỏ. Người máu bạc được coi là ưu việt, họ là những ông vua, hoàng hậu, công chúa, hoàng tử... tóm lại là tầng lớp quý tộc, họ có khả năng điều khiến nước, lửa, gió... Còn người máu đỏ thì ngược lại, họ không có khả năng đặc biệt, bị coi là thấp kém. Nhưng sau này xuất hiện nhân vật Mare, dù là người máu đỏ nhưng lại có khả năng điều khiển sấm sét. Nội dung truyện không mới nhưng rất hay, rất nhiều plot twist, đọc bị lừa lần này sang lần khác. Bìa sách đẹp nhưng dễ quăn, sách nhẹ, giấy hơi mỏng, câu từ khá đơn giản, mình không giỏi tiếng Anh lắm nhưng vẫn đọc tốt. Mong Fahasa nhập về thêm nhiều cuốn như thế này.', '', '', ''),
(8, 'Đắc Nhân Tâm', 2, 'sach-dac-nhan-tam-kho-lon-tai-ban-2023-sbooks.jpg', 2, 'Đắc nhân tâm (Được lòng người), tên tiếng Anh là How to Win Friends and Influence People là một quyển sách nhằm tự giúp bản thân (self-help) bán chạy nhất từ trước đến nay. Quyển sách này do Dale Carnegie viết và đã được xuất bản lần đầu vào năm 1936, nó đã được bán 15 triệu bản trên khắp thế giới.', 'Nguyễn', 'Thế Giới', 'SaiGon Book'),
(10, 'Tuổi trẻ đáng giá bao nhiêu', 4, 'Screenshot 2023-09-30 121243.png', 4, 'Tuổi trẻ đáng giá bao nhiêu được ấn hành bởi Nhã Nam với giá bìa 70.000 đồng. Nhưng cái giá cho những điều nhận được từ nó thì nhiều hơn thế. Với cuốn sách này, chúng ta có thể tìm thấy những chiêm nghiệm đắt giá. Từ đó, bước vào cuộc đời theo cách nhẹ nhàng và đón nhận những thử thách mới dễ dàng hơn.', '', '', ''),
(11, 'Cây Cam Ngọt Của Tôi', 5, 'Screenshot 2023-09-30 121454.png', 2, 'Sách \"Cây cam ngọt của tôi\" là tự truyện về thời thơ ấu của cậu bé Zézé, mang bài học về sự thấu cảm và lòng trắc ẩn. Tiểu thuyết dày 244 trang, do José Mauro de Vasconcelos sáng tác (Nguyễn Bích Lan - Tô Yến Ly dịch). Trong nước, tác phẩm nằm trong top ấn phẩm bán chạy của các đơn vị sách năm 2022.', '', '', ''),
(12, 'Kỹ Năng Giao Tiếp Đỉnh Cao', 6, 'Screenshot 2023-09-30 121346.png', 4, '“Tâm Phật” là trái tim dịu dàng, mềm mại, thiện lành nhất. Còn “khẩu xà” là miệng lưỡi cay nghiệt, sắc nhọn, hung hãn nhất. Rõ ràng đã hy sinh rất nhiều, rõ ràng là quan tâm rất nhiều, nhưng chỉ vì cái miệng, chỉ vì vài câu nói, thành ra oán giận, thành ra thù hằn, như vậy có đáng không? Tất nhiên, nhiều người “khẩu xà” nhưng lòng dạ họ không xấu, thậm chí đa số họ đều là những người chính trực, thẳng thắn, khảng khái. Nhưng làm gì có ai có đủ kiên nhẫn để tìm hiểu sâu xa, cặn kẽ về tất cả mọi người mà họ tiếp xúc. Khuôn miệng của bạn chính là tấm danh thiếp đầu tiên bạn thảy ra ngoài xã hội, nếu vừa mở miệng đã như vung đao khua kiếm, bất luận tâm của bạn “tâm Phật” hay “tâm xà”, thì đối với người bị “đao kiếm” của bạn làm cho thương tổn, đều như nhau cả thôi. Nếu bạn có ', '', '', ''),
(13, 'Thích Nhất Hạnh', 33, 'Screenshot 2023-09-30 121543.png', 2, 'Cuốn sách “Không diệt, không sinh đừng sợ hãi” gồm 219 trang và 9 chương, sách của thầy Nhất Hạnh luôn đem đến cho bạn đọc những góc nhìn rất sâu sắc về cuộc đời. Thầy gọi Trái Đất bằng cái tên rất thân thương “Đất Mẹ”, cách thầy thưởng thức cuộc sống cũng vô cùng thi vị, mỗi một bước chân, hoạt động hàng ngày cũng là mắt thương nhìn cuộc đời, với sự thấu hiểu đặc biệt sâu sắc của mình, thầy Thích Nhất Hạnh đã viết nên cuốn sách “Không diệt, không sinh đừng sợ hãi” một chân lý sống tự do, giảm bớt mọi muộn phiền về quan niệm sinh, tử mà bấy lâu nay ta vẫn bị mắc kẹt.', 'Thích Nhất Hạnh', 'Saigon Books', 'Thế giới'),
(14, 'Những Cuộc Phiêu Lưu Kì Thú Robinson Crusoe', 9, 'Screenshot 2023-10-07 115941.png', 1, 'Toàn bộ câu chuyện xoay quanh nhân vật Robinson với một anh chàng ưa hoạt động và ham thích phiêu liêu, mạo hiểm say sưa đi đến miền đất lạ, bất chấp sóng to gió lớn và những mối nguy hiểm trước mắt.', '', '', ''),
(15, 'BÁCH KHOA THƯ HÌNH ẢNH VỀ CÁC LOÀI VẬT TRÊN TRÁI ĐẤT', 13, 'dong-vat-bach-khoa-thu-hinh-anh-ve-cac-loai-vat-tren-trai-dat-bia.jpg', 1, 'Động vật – Bách khoa thư hình ảnh về các loài vật trên Trái Đất bao gồm vô vàn thông tin và hình ảnh về những sinh vật tuyệt vời đang cư ngụ trên hành tinh xanh chúng ta, từ thực vật đến động vật...', '', '', ''),
(16, 'SCIENCE ENCYCLOPEDIA', 22, 'science-encyclopedia-bach-khoa-thu-ve-khoa-hoc-the-gioi-dong-vat.jpg', 1, 'Science Encyclopedia - Bách Khoa Thư Về Khoa Học - Thế Giới Động Vật là cuốn sách bách khoa tra cứu thuận tiện và dễ dàng ghi nhớ dành cho những bộ óc mê khám phá!', '', '', ''),
(17, ' LƯỢC SỬ LOÀI NGƯỜI BẰNG TRANH', 32, 'sach-sapiens-luoc-su-loai-nguoi-bang-tranh-tap-1-khoi-dau-cua-loai-nguoi.jpg', 1, 'Sapiens - Lược Sử Loài Người Bằng Tranh - Tập 1 - Khởi Đầu Của Loài Người - Bộ truyện tranh này được chuyển thể từ cuốn sách best-seller “Sapiens: Lược Sử Loài Người” của tác giả nổi tiếng Yuval Harari.', '', '', ''),
(19, '  Muôn Kiếp Nhân Sinh 3', 19, 'muonkiepnhansinh.jpeg', 2, 'Nối tiếp câu chuyện và tinh thần của tập 1 và tập 2, Muôn Kiếp Nhân Sinh 3 tiếp tục đưa bạn đọc đi qua hành trình thức tỉnh tâm linh của nhân vật chính Thomas. Không chỉ là hồi tiếp theo trong chuyến phiêu lưu của linh hồn, tập mới nhất và cũng là tập cuối cùng của bộ sách sẽ bàn luận sâu hơn về hiện tại và tương lai của nhân loại, đồng thời nhẹ nhàng khép lại câu chuyện tiền kiếp nhiều trăn trở, nhiều bài học của Thomas và giải đáp những câu hỏi còn bỏ ngỏ từ hai tập trước.', '', '', ''),
(20, ' Tội ác sau những bức tranh', 18, 'bcutrang.jpeg', 3, '    Rời trung tâm cai nghiện, Mallory Quinn nhận công việc trông trẻ cho gia đình nhà Maxwell. Cô chăm sóc cho cậu con trai năm tuổi của họ, Teddy. \r\n\r\n\r\n\r\n    Mallory cảm thấy hài lòng với công việc hiện tại của mình. Cô có một không gian sống riêng, có thể tập chạy bộ mỗi tối, và có được sự ổn định mà cô hằng khao khát. Mallory cũng có được mối quan hệ gắn bó chân thành với Teddy, một cậu bé ngọt ngào nhưng nhút nhát, không thể sống thiếu sổ vẽ và bút chì. Những bức vẽ của cậu bé có nội dung rất đỗi bình thường: cây cối, thỏ, bóng bay… ', '', '', ''),
(21, ' Những Cái Chết Bí Ẩn', 20, 'caichet.jpeg', 3, 'Làm cách nào để một “xác chết lên tiếng”? - đó là công việc của bác sĩ pháp y. \r\n“Ghi chép pháp y - Những cái chết bí ẩn” là cuốn sách nằm trong hệ liệt với “Pháp y Tần Minh” - bộ tiểu thuyết nổi đình đám của xứ Trung đã được chuyển thể thành series phim. Cuốn sách tổng hợp những vụ án có thật, được viết bởi bác sĩ pháp y Lưu Hiểu Huy - người có 15 năm kinh nghiệm và từng mổ xẻ hơn 800 tử thi. ', '', '', ''),
(22, 'Người rỗng', 21, 'Screenshot 2023-10-11 160540.png', 3, 'Người rỗng là tác phẩm đỉnh cao của John Dickson Carr trong thể loại “mật thất án mạng”. Xuyên suốt truyện là bí ẩn của hai vụ giết người: một vụ xảy ra trong căn phòng khóa kín, nạn nhân chỉ có thể mấp máy vài từ đứt đoạn; một vụ diễn ra trên con phố vắng, có nhân chứng ở hai đầu. Trong cả hai vụ, kẻ thủ ác đều biến mất không dấu vết. Nhân chứng nhìn thấy hắn, rồi để hắn thoát đi như một màn ma thuật', '', '', ''),
(23, 'Người vô hình', 30, 'vohinh.jpeg', 3, 'Người Vô Hình là một trong những tiểu thuyết nổi tiếng nhất trong đời viết văn của H.G. Wells, tác gia lớn người Anh. Truyện kể về Griffin, nhà khoa học nghèo có tài năng thiên bẩm về vật lí, người đã tìm ra bí thuật tàng hình.', '', '', ''),
(24, 'Muốn an được an', 32, 'AN.jpeg', 2, 'Ngày chủ nhật và cũng là ngày cuối cùng của tháng 11 năm 2014 tôi nhận được bản thảo cuốn sách Muốn an được an của thiền sư Thích Nhất Hạnh đã được sư cô Hội Nghiêm dịch ra tiếng Việt từ bản nguyên gốc tiếng anh Being peace. Tôi ngồi vào bàn rồi đọc ngay tức khắc. Và tôi giật mình. Giật mình bởi mình quá may mắn mà không biết đến điều đó. May mắn vì tính đến năm 2015 này tôi được biết đến thiền sư Thích Nhất Hạnh đúng 10 năm. ', '', '', ''),
(25, '  Nghệ Thuật Sống Vững Vàng', 12, '0ucbg8b1q8yyky991i7z0x2opcb82acq.jpeg', 4, '    Con đường dẫn đến thành công bền vững và một cuộc sống trọn vẹn -\r\n\r\n\r\n\r\n    Cuộc sống tất bật ngày nay dễ khiến người ta sợ cảm giác bị bỏ lại phía sau. Để bắt kịp bạn bè hay đồng nghiệp, rất nhiều người đã chọn cách quay cuồng trong công việc, ráo riết theo đuổi hết mục tiêu này tới thành tựu khác, để rồi vào những phút giây hiếm hoi khi guồng quay đó dừng lại, họ lại rơi vào cảm giác mông lung vô định, không biết mình phải đi đâu về đâu.', '', '', ''),
(26, 'Nắng Ấm Sau Mưa', 31, 'tdvtby42qe5m67ixenuotrzoiz727oo5.jpg', 4, 'Có một sự thật rằng ngay cả khi bạn đã cố gắng để đạt được sự ổn định nhất có thể, những biến cố trong cuộc sống là điều không thể tránh khỏi. Mất mát, đổi thay, thất bại, tai nạn, bệnh tật, thảm họa thiên nhiên… hầu như bất kỳ thứ gì ập đến với ta, dù chỉ trong chớp mắt, cũng có thể làm thay đổi cuộc đời ta mãi mãi.\r\n\r\nBạn sẽ làm gì nếu một ngày kia mọi kế hoạch của bạn đều đi trật hướng, tương lai trở nên bấp bênh và niềm tin vào bản thân bắt đầu lung lay? Bạn sẽ dựa vào ai nếu một sớm mai thức dậy, bạn cảm giác như cả thế giới đang quay lưng với mình?', '', '', ''),
(27, 'Những Chồi Non Hy Vọng', 12, 'w4gbkbmi6uj2p8mq85ohbs4jnvrus54o.jpg', 4, 'Cuộc sống hiện đại với những muộn phiền, lo toan, đôi lúc khiến ta cảm thấy căng thẳng, bất an. Mỗi ngày đi qua, chúng ta giữ lại những năng lượng tiêu cực tích tụ bên trong mình. Chúng không chỉ ảnh hưởng đến cuộc sống cá nhân mà còn có thể vô tình khiến ta làm tổn thương người khác. Vậy làm thế nào để thoát khỏi tình trạng đó? ', '', '', ''),
(28, '  Vượt Qua Dông Bão', 32, 'cwjivz4i68dgd8il3s8dmixq8y1w6woj.jpg', 4, 'Những khó khăn cùng cực nhất, bài học thấm thía nhất, cho đến đổi thay quý giá nhất… đó là những gì mà đại dịch COVID-19 đã mang lại cho chúng ta. \r\n \r\nKhông chỉ dịch bệnh, từ năm 2020 trở lại đây, thế giới đã trải qua nhiều biến động như thiên tai, chiến tranh, suy thoái kinh tế… Tất cả xảy đến với sức tàn phá kinh hoàng như một cơn bão dữ quét qua cuộc sống thường ngày, buộc mỗi người chúng ta phải chuyển mình để thích nghi. ', '', '', ''),
(29, '  Gieo Hạt Mầm Tử Tế', 34, 'wo9re1gqs1tcwb2vkqzejfi5dnhfidu3.jpg', 4, 'Bạn có nghĩ một hành động nhỏ của mình có thể thay đổi cuộc đời của một người nào đó không, hoặc… ngược lại?\r\n\r\nỞ thời đại mà những tin tức xã hội tiêu cực tràn ngập mặt báo, các chủ đề về bạo lực, chiến tranh hay tiêu đề giật gân về đời sống riêng tư của người nổi tiếng lại là từ khóa được nhiều người tìm kiếm, thật khó để tin rằng thế giới này vẫn còn tồn tại tình yêu thương, sự tử tế hay những hành động giúp đỡ vô điều kiện giữa người với người. ', '', '', ''),
(30, '  Tu Giữa Đời Thường', 63, 'ktwgm07agf23g4cruela6ppdpaaqkbvn.jpg', 4, 'Thế giới hiện đại, đặc biệt là nhịp sống hối hả của môi trường đô thị khiến con người ngày càng mất kết nối với tự nhiên, rời xa bản chất đích thực để chạy theo các khuôn mẫu bên ngoài. Khủng hoảng của con người đô thị hiện đại diễn ra ở hầu hết các khía cạnh đời sống, khiến chúng ta kiệt sức, thiếu thời gian, rơi vào lối sống trì trệ, chán ghét bản thân và không tìm thấy ý nghĩa sống.', '', '', ''),
(31, 'Hạnh phúc và những điều nhỏ bé quan trọng khác', 23, 'Screenshot 2023-10-11 190243.png', 2, 'Dựa trên nguồn tư liệu văn học và triết học đồ sộ , từ Alice ở xứ sở thần tiên, Hoàng tử bé dến Lev Tolstory ,King Solomon và Friedrich Nietzshce ,Haim Shapira đã thách thức những quan niệm xưa cũ về hạnh phúc của độc giả, giúp chúng ta biết trân trọng những điều nhỏ bé nhưng có tầm quan trọng lớn lao trên hành trình của đời sống.Nếu như ý định khiến con người \"\"hạnh phúc\"\" không nằm trong kế hoạch của \"\"Đấng sáng thế\"\" con người chúng ta cần làm gì để có một cuộc đời đáng sống với những phút giây của niềm vui thực sự?\"', '', '', ''),
(32, ' The Magic of Thinking Big', 31, 'ol7jnr0zrkv1s0cins0hb38qihu9s5yi.jpeg', 4, '    Hãy thử nghĩ về những người có mức thu nhập cao hơn bạn gấp 5 lần. Có phải họ thông minh hơn bạn gấp 5 lần? Họ làm việc vất vả hơn bạn gấp 5 lần? Nếu câu trả lời của bạn là “không” thì bạn sẽ chạm đến câu hỏi này: “Vậy, họ có những đức tính, phẩm chất hay bí quyết gì mà tôi không có?”', '', '', ''),
(33, 'Nghệ thuật xếp giấy Nhật Bản', 42, 'uzpitr0xfwwbmbv2q6bchn21lpz3n4l8.jpeg', 4, '  Bạn biết không, chỉ cần những mẩu giấy có kích cỡ cần thiết thôi là bạn đã có thể xếp được theo ý muốn khá nhiều hình ảnh khác nhau. Yêu cầu của trò chơi xếp giấy này sẽ rèn luyện cho bạn biết cách nhìn hình mẫu thật kỹ, nắm bắt được những kỹ thuật xếp, gấp để có thể tạo ra những mẫu gấp hình thật đẹp.', '', '', ''),
(34, '  Giao tiếp bất kỳ ai', 43, '3jh4p8ve4kz6u22e8l80dm8aw4tffwrq.jpeg', 4, 'Một doanh nghiệp thành công hay thất bại thường tùy thuộc vào những kỹ năng giao tiếp nhiều hơn là phát triển kỹ thuật. Cuốn sách tuyệt vời này giúp bạn nâng cao các kỹ năng giao tiếp như nghe và nói trên mọi phương diện; với cả những yếu tố khác như: ngôn ngữ cơ thể, hành vi ứng xử và thái độ… giúp bạn có thể chinh phục được khách hàng, nhà cung cấp và tất cả những người liên quan tới bạn. Jo và Bennie thừa đủ tư cách để giúp bạn phát triển mạnh mẽ doanh nghiệp của mình.', '', '', ''),
(35, 'Search Inside Yourself', 54, '7k27z4yvxtqmqijapg7yioa36a6qjjzu.jpeg', 4, 'Tất cả chúng ta đều biết công cụ tìm kiếm Google và công ty Google với văn hóa doanh nghiệp tuyệt vời nổi tiếng khắp thế giới, nhưng liệu có bao nhiêu người trong số chúng ta biết được điều gì đã làm nên nền tảng cho sự nổi tiếng đó? Chade-Meng Tan – tác giả cuốn sách Search Inside Yourself sẽ giải thích cho bạn bí mật đó.', '', '', ''),
(36, 'Năng lực sống sót trong kỷ nguyên mới', 54, 'bg601exq741gxydcmsen90il8742psl2.jpeg', 4, 'BQ – Năng lực sống sót trong kỷ nguyên mới\r\nKhi xã hội thay đổi cấu trúc và sự cạnh tranh ngày càng gay gắt, lực lượng lao động theo tư duy cũ sẽ bị đào thải.\r\nKhông có vùng an toàn.\r\nTất cả chúng ta, dù muốn hay không, đều bị nhấn chìm trong vòng xoáy của cuộc chơi chọn lọc đó.\r\nVậy, những nhân viên như thế nào sẽ tồn tại được?  \r\nChìa khóa chính là “Chỉ số thông minh kinh doanh – BQ”, một chỉ số đã được thế giới công nhận là bí quyết để đổi mới.', '', '', ''),
(37, 'Sống sót sau những cú shock kinh doanh', 12, 'Screenshot 2023-10-11 191429.png', 3, 'Theo các chuyên gia tài chính, do ảnh hưởng của dịch COVID-19, trong 7 tháng năm 2021, gần 80.000 doanh nghiệp đã phải rời bỏ thị trường. Từ nay đến hết năm, nếu Việt Nam có thể kiểm soát được dịch bệnh và phục hồi kinh tế, số lượng doanh nghiệp phá sản cũng ở mức 100.000. Hiện mỗi tháng có khoảng 10.000 doanh nghiệp phá sản. Trường hợp nếu không kiểm soát được dịch bệnh, sẽ có khoảng 150.000 doanh nghiệp phá sản trong năm nay.', '', '', ''),
(38, '25 nhân vật lịch sử', 14, 'qt3td7387xa8elp6gdzmnpda216dzbf6.jpeg', 3, 'Lịch sử của cả quốc gia lẫn cá nhân đều không tồn tại chữ “nếu”!\r\n\r\n\r\n\r\n    Tuy nhiên, việc suy ngẫm về từng thời điểm nào đó và đặt ra những giả thuyết “nếu…thì…” thật thú vị!\r\n\r\n\r\n\r\n    Ở trường học sinh sợ học môn lịch sử một phần là vì khi học các em có rất ít cơ hội, không gian và điều kiện đảm bảo để có thể tưởng tượng “nếu…thì…” hoặc suy ngẫm về các biến cố của quốc gia hoặc cuộc đời của các cá nhân ở nhiều góc độ khác nhau.\r\n\r\n\r\n\r\n    Lịch sử vì thế trở thành một thứ “lịch sử vô nhân xưng”, dễ rơi vào chung chung và trừu tượng. Để bù đắp nhược điểm cố hữu đó của môn lịch sử trong trường học (không chỉ là ở Việt Nam), học sinh cần đọc các sách về lịch sử ở bên ngoài.', '', '', ''),
(39, 'SỨC MẠNH CỦA NHỮNG VẾT THƯƠNG', 21, 'emw2aln2tkc9yi8fk0g6oi9bp1h7bmi8.jpeg', 3, '“Sức mạnh của vết thương” là tập tiểu luận phê bình mới nhất của nhà lý luận phê bình\r\nHoàng Thụy Anh được phát hành đầu năm nay. Hoàng Thụy Anh được biết đến là một nhà phê bình tài năng với nhiều thành tựu ấn tượng. Tác giả không ngừng tìm hiểu và phân tích phê bình ở nhiều thể loại văn chương khác nhau. Trong “Sức mạnh của vết thương”, Hoàng Thụy Anh đã phân tích nhiều tác phẩm có thể loại sáng tác khác nhau. Nhưng đều nói đến một chủ đề là thân phận người phụ nữ và “vết thương\" của họ. ', '', '', ''),
(40, 'Thành Cát Tư Hãn là ai?', 25, 'Screenshot 2023-10-11 192607.png', 3, 'Hãy cùng đọc bộ sách “Là ai? - Chân dung những người làm thay đổi thế giới\" để hiểu được những thăng trầm, những biến cố, những thành công trong cuộc đời của mỗi thiên tài. Từng câu, từng chữ miêu tả một cách chân thực nhất nội tâm cảm xúc nhân vật cũng những hình ảnh minh họa sống động giúp cho bất kỳ ai cũng có cảm nhận như chúng ta đang được chính những vị danh nhân ấy kể chuyện cho nghe vậy.', '', '', ''),
(41, 'Bán đảo Ả rập', 27, 'Screenshot 2023-10-11 192847.png', 3, 'Bán đảo Ả rập là đế quốc của Hồi giáo gồm 7 quốc gia: Ai cập, Syrie, Liban, Jorrdanie, Irak, Ả Rập Sesoudite, Yeman, mà cũng là đế quốc của dầu lửa, vì dầu lửa chi phối nó cũng như Hồi giáo, còn mạnh hơn Hồi giáo. Hồi giáo liên kết Ả Rập thì Dầu lửa chia rẽ Ả Rập. Và vậy mà ba bốn chục năm nay ở bán đảo Ả Rập xảy ra không biết bao nhiêu xung đột: xung đột giữa các đế quốc, xung đột giữa các quốc gia Ả Rập, xung đột giữa các đảng phái trong mỗi quốc gia... ', '', '', ''),
(42, 'Hồi ký Nguyễn Hiến Lê', 28, 'jpr71l14bhntfp0u897r7nrfxjtwele1.jpeg', 3, 'Mở đầu cuốn sách Đông Kinh Nghĩa Thục Nguyễn Hiến Lê có viết: Mà có bao giờ người ta nghĩ tới cái việc thu thập tài liệu trong dân gian không? Chẳng hạn khi một danh nhân trong nước qua đời, phái một người tìm thân nhân hoặc bạn bè người mất để gom góp hoặc ghi chép những bút tích cùng dật sự về vị ấy, rồi đem về giữ trong các thư khố làm tài liệu cho đời sau. Công việc có khó khăn tốn kém gì đâu, mà lợi cho văn hóa biết bao.\r\nVới  những suy nghĩ đó mà có cái để người đời sau biết đến người hiền tài. Bởi lẽ vậy nên cụ Nguyễn Hiến Lê không chỉ viết về nhiều vị danh nhân trên khắp thế giới mà còn dành chút thời gian viết về mình với  tác phẩm Hồi Ký Nguyễn Hiến Lê bàn về Cuộc đời và tác phẩm của cụ. Cuốn sách được Bizbooks xuất bản như một lời tri ân đến cụ Nguyến Hiến Lê, gia đình, bạn bè, cộng đồng yêu mến cụ.', '', '', ''),
(43, 'Tăng huyết áp kẻ giết người thầm lặng', 11, 'kgvevbruijvfusxm8y4w6fjpiju8e8kg.jpeg', 3, 'Tài liệu này được biên soạn nhằm mục đích giúp cho người bệnh có thêm những hiểu biết thường thức trong việc tự chăm sóc bảo vệ sức khỏe cho chính bản thân, gia đình và cộng đồng', '', '', ''),
(44, 'Chúng Tôi Cần Bạn', 4, 'd5er9onm9xzx9unoiv0c098321qxyf32.jpg', 2, 'Cuộc sống là một hành trình dài với vô số biến cố và thử thách đòi hỏi chúng ta phải vượt qua, nhưng cuộc sống không phải là cái bẫy để chờ chúng ta sa vào rồi phán xét, mà những biến cố, thử thách đó sẽ giúp chúng ta trưởng thành hơn bằng những bài học sâu sắc đằng sau nó. Vậy chúng ta học được gì từ cuộc sống? Có lẽ là rất nhiều, nhưng có những bài học mà chúng ta sẽ không thể nào bỏ qua:\r\nBài học về sự quan tâm: Trong cuộc sống ai cũng cần sự quan tâm, yêu thương và chia sẻ. Quan tâm tới một người không đơn giản chỉ là việc xem người ấy sống thế nào, cuộc sống có đầy đủ hay không.', '', '', ''),
(45, 'Bài Học Về Sự Hy Sinh', 3, '789ftvrcsz7b36v1lr7668bcx5wcfo3q.jpg', 2, 'Cuốn sách tập hợp những câu chuyện kể mang tính giáo dục về sự hy sinh, thể hiện tình yêu thương đối với mọi người xung quanh: Sự hy sinh cao cả; Tha thứ mãi mãi; Người mẹ thực vật; Vết sẹo...', '', '', ''),
(46, 'Chân dung Ngô Tất Tố', 32, '4cq1riyvijw31xf6jx1qh0dux6kujg69.jpeg', 2, 'Ngô Tất Tố là một trong những cây bút tiêu biểu của dòng văn học hiện thực phê phán những năm 30, 40 của thế kỉ XX. Ngô Tất Tố không chỉ là nhà viết tiểu thuyết, phóng sự, ông còn là một nhà báo cự phách, một nhà khảo cứu dịch thuật có tài, một nhà văn hóa lớn của dân tộc. Thành công của Ngô Tất Tố là thành công của quan điểm nghệ thuật vị nhân sinh, của một người cầm bút tự thấy phải hoạt động, phải xông pha, phải lăn lộn với cuộc sống nhân sinh. Ông luôn khiến mọi người nể trọng bởi bút lực dồi dào, bởi tinh thần “phản tỉnh” bản thân và xã hội một cách sâu sắc, tinh tế trong bất cứ lĩnh vực văn chương nào', '', '', ''),
(47, 'Những nỗi buồn ở chế độ lặng im', 5, 'wte2chfq03gi9qukzzan8gu6jv5hirtg.jpeg', 2, 'Cuốn sách “Những nỗi buồn ở chế độ lặng im” – tác phẩm đầu tay của tác giả trẻ đầy tài năng Per sẽ cùng bạn đi qua từng chặng đường của thanh xuân. Bằng những vần thơ giản dị, gần gũi tác giả đưa chúng ta trải qua từng cảm xúc trên hành trình trưởng thành.', '', '', ''),
(48, 'Cà phê đợi một người', 13, '6gqx0zdsipjsqgrbj0hzm80jq8zl85k1.jpeg', 2, 'Trạch Vu đang đợi một người con gái mà trước mặt người ấy anh không phải nguỵ trang.\r\nBách Giai đang đợi một người con trai mà cậu ấy không phải chịu áp lực lựa chọn.\r\nA Thác đang đợi một cô gái tốt biết cách trân trọng bản chất thuần phác của anh.\r\nCòn tôi giờ đang đi đến đoạn vĩ thanh của bài toán sắp xếp tổ hợp tình yêu này. Trong quán cà phê Đợi Một Người, bên những tách cà phê hương vị khác nhau, chúng tôi đều đang đợi lời giải cho bài toán trái tim mình.', '', '', ''),
(49, 'Am Mây Ngủ', 7, 'Screenshot 2023-10-11 204413.png', 2, 'Truyện Am Mây Ngủ tuy nói về công chúa Huyền Trân nhưng ở đây hình ảnh công chúa Huyền Trân không thể tách rời ra khỏi hình ảnh của người tăng sĩ áo vải sống trên am Ngọa Vân núi Yên Tử. Người ấy là Trúc Lâm Đại sĩ, tổ thứ nhất của Thiền phái Trúc Lâm.', '', '', ''),
(50, 'Trở về Eden', 56, '8ekd72wlegsycfzhlao9q62rfah08f3x.jpeg', 2, 'Trở về Eden – cuốn tiểu thuyết tâm lý tình cảm đặc sắc của Rosalind Miles như một thước phim dài cuốn hút người đọc bởi kịch tính, lãng mạn và quyết liệt.\r\n\r\n\r\n\r\n    Stephany Harper được thừa hưởng gia tài khổng lồ của người cha để lại và thiên đường hoang dã Eden – nơi cô muốn xây dựng hạnh phúc thực sự với người chồng mà cô yêu say đắm là Grey Marsdan – một ngôi sao quần vợt hào hoa. Sự đố kỵ của Jilly – người bạn gái thân thiết nhất và ham muốn dục vọng trong con người Grey đã cộng hưởng trở thành tội ác man rợ đối với Stephany. Chính ở Eden, khi đã nằm trong hàm cá sấu, cô mới nhìn thấy bộ mặt thật của bạn thân và chồng cô.', '', '', ''),
(51, 'Yêu, Dại Dột, Yêu', 15, 'ejr4k5ibfzbrc8wlmx7ocr1zy3e06r4r.jpeg', 2, 'Không có thông tin', '', '', ''),
(52, 'Tựa Lưng Vào Nỗi Nhớ', 19, 'sgbim8wi58undq6j0035x3vv1sao6d3o.jpeg', 2, 'Không có thông tin', '', '', ''),
(53, 'Dế mèn phiêu lưu ký (1941)', 19, 'Sach-6-6245-1438056744.jpg', 1, 'Ấn bản đầu tiên vào năm 1941 của cuốn sách này có tên là Con dế mèn, chỉ gồm ba chương đầu tiên. Khi được độc giả đón nhận nồng nhiệt, tác giả Tô Hoài bắt tay viết thêm những chương sau để ra mắt một tác phẩm hoàn chỉnh có tên Dế mèn phiêu lưu ký. Từ đó, cuốn sách ghi dấu ấn tuổi thơ của biết bao thế hệ người Việt Nam. Câu chuyện là quá trình lớn lên, trưởng thành và dấn thân vào chuyến phiêu lưu khám phá thế giới rộng lớn của một chú dế rất bé nhỏ nhưng rất mạnh mẽ.', '', '', ''),
(54, 'Đồi thỏ (1972)', 45, 'Sach-7-7493-1438056745.jpg', 1, 'Đồi thỏ được nhà văn Anh Richard Adams viết khi đã nghỉ hưu. Đây không chỉ là một tác phẩm dành cho thiếu nhi mà còn là một thiên sử thi hào hùng về loài động vật thường bị coi là nhút nhát, rụt rè. Quyển sách tôn vinh thiên nhiên, sức mạnh của tập thể lẫn khả năng sinh tồn đặc biệt của loài Thỏ.', '', '', ''),
(55, 'Cuộc phiêu lưu của Văn Ngan tướng công (1986)', 38, 'van-ngan-tuong-quan-1-9743-1438056745.jpg', 1, 'Đây là tác phẩm ghi lại cuộc phiêu lưu của một chú Ngan với những câu chuyện buồn vui thăng trầm trên bước đường viễn du. Với cách viết giản dị, pha trộn giữa chất hiện thực và đồng thoại, quyển sách mở ra một cái nhìn chân thực mà không kém phần mộng mơ về thế giới. Giọng văn dí dỏm, hài hước của tác giả Vũ Tú Nam đưa Văn Ngan tướng công trở thành một nhân vật điển hình của tuổi thơ của rất nhiều độc giả Việt Nam.', '', '', ''),
(56, 'Tôi là con mèo', 23, '582.jpg', 1, 'Câu chuyện này được giới văn học Nhật Bản đánh giá là một trong những tác phẩm độc đáo để lại dấu ấn khó phai trong lòng người đọc.\r\n\r\nGiàu tính ngụ ngôn và không khó đọc, Tôi là con mèo là biên niên sử của một con mèo bị vứt bỏ, không được yêu thương và nó đi lang thang khắp nơi để quan sát bản chất của con người – từ những chuyện kịch tính của các nhà doanh nhân và giáo viên cho đến những góc khuất của những kẻ tu hành và những kẻ đứng đầu. Từ góc nhìn độc đáo này, tác giả Natsume Soseki đã cay đắng bình luận về những biến động xã hội thời Minh Trị sau khi hoàn thành xong khóa triết học Trung Quốc.', '', '', ''),
(57, 'Bởi vì Winn', 46, '579.jpg', 1, 'Vào một ngày mùa hè, Opal và cha cô bé, nhà thuyết giáo, chuyển đến Naomi, Florida. Opal đi đến siêu thị tên Winn-Dixie và đi ra với một con chó. Một con chó to, mình mẩy hôi hám, răng vàng ỉn nhưng hay cười. Cô bé đặt tên nó theo tên cửa hàng siêu thị Winn-Dixie. Nhờ có Winn-Dixie, cha Opal kể cho cô 10 điều về người mẹ đã mất, mỗi năm kể một điều.', '', '', ''),
(58, 'Ngựa ô yêu dấu', 56, '588.jpg', 1, 'Cuộc sống của một chú ngựa có thể tràn đầy yêu thương và sự dịu dàng, nhưng cũng có thể bị lấp đầy bởi sự hèn hạ và độc ác. Chú ngựa đen đã tìm hiểu về hai khía cạnh này trong câu chuyện kinh điển viết bởi Anna Sewel.', '', '', ''),
(59, 'Gió qua rặng liễu (1908)', 67, 'Sach-9-6882-1438056744.jpg', 1, 'Cuốn sách được nhà văn người Anh Kenneth Grahame viết năm 1908. Hơn một thế kỷ trôi qua, tác phẩm dạt dào chất thơ này vẫn bền bỉ lay động độc giả khắp nơi trên thế giới. Câu chuyện phiêu lưu của những người bạn nhỏ gồm Chuột Chũi, Chuột Nước, Cóc, Lửng qua dòng sông, bờ cỏ, khu rừng làm bừng sáng cả vùng đầm lầy và mang mùa xuân đến. Một thế giới gần gũi đã mở ra theo bước chân của những con vật, với bao cảnh trí kỳ ảo chứa đựng đam mê tuổi trẻ.', '', '', ''),
(60, 'Chuyện con mèo dạy hải âu bay (1996)', 99, 'Sach-3-2599-1438056746.jpg', 1, 'Cuốn sách là câu chuyện về chú mèo tên Zorba nhận của một cô hải âu sắp qua đời một quả trứng với lời hứa danh dự: sẽ ấp trứng nở, nuôi hải âu con trưởng thành và dạy cho hải âu biết bay. Lời hứa danh dự của loài mèo trở thành một bài học lớn cho thiếu nhi - thủ tín và yêu thương vô điều kiện.', '', '', ''),
(61, 'Cô gà mái xổng chuồng (2000)', 56, 'Sach-5-8672-1438056746.jpg', 1, 'Cô gà mái tự đặt cho mình cái tên Mầm Lá là cô gà mái đặc biệt trong chuồng, không chỉ biết cúi đầu ăn mà còn biết ngắm những tán cây ngoài lưới sắt. Không chấp nhận cuộc sống quẩn quanh chỉ biết ăn và đẻ trứng, cô nuôi ý định vượt rào đến với thế giới bên ngoài.', '', '', ''),
(62, 'Chuyện Despereaux (2003)', 97, 'Sach-4-3700-1438056746.jpg', 1, 'Tác phẩm kể về một chú chuột có thân hình bé nhỏ ra đời với cái tên Nỗi Thất Vọng nhưng lại có tình yêu mãnh liệt với âm nhạc, ánh sáng và những câu chuyện cổ tích. Nhà văn Mỹ Kate DiCamillo đã đưa độc giả đến với một thế giới lãng mạn của công chúa, hiệp sĩ, của phiêu lưu mạo hiểm và trên hết là về lòng can đảm của một chú chuột đã dám trở nên khác biệt.', '', '', '');

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
  `avatar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`, `phone`, `location`, `avatar`) VALUES
(4, 'deptrai', 'Datboyngeo@gmail.com', '202cb962ac59075b964b07152d234b70', 'admin', 0, '0', ''),
(19, 'TRIỆU TIẾN ĐẠT', 'tiendat220404@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'user', 2147483647, 'tanphu1, di linh, dinh lac, lam dong `12', 'nguoi.jpg'),
(20, 'nhi', 'yen542182@gmail.com', '698d51a19d8a121ce581499d7b701668', 'user', 545521316, 'hồ chí minh', 'IMG_3987.JPG');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
