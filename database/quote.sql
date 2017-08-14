-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: 10.169.0.145
-- Generation Time: Aug 10, 2017 at 03:41 PM
-- Server version: 5.7.17
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shinyide2_quotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `match_text` varchar(128) DEFAULT NULL,
  `period` varchar(128) DEFAULT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `match_text`, `period`, `added`) VALUES
(1, 'Baltasar Gracian', 'baltasargracian', NULL, '2017-08-10 13:06:24'),
(2, 'Richard Wright', 'richardwright', NULL, '2017-08-10 13:10:46'),
(3, 'Dag Hammarskjold', 'daghammarskjold', NULL, '2017-08-10 13:14:10'),
(4, 'Marcus Aurelius', 'marcus aurelius', NULL, '2017-08-10 13:16:54'),
(5, 'George Carlin', 'georgecarlin', NULL, '2017-08-10 14:01:06'),
(6, 'Albert Einstein', 'alberteinstein', NULL, '2017-08-10 14:03:48'),
(7, 'Michael Jordan', 'michaeljordan', NULL, '2017-08-10 14:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `quote`
--

CREATE TABLE IF NOT EXISTS `quote` (
  `id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `quote_text` varchar(512) DEFAULT NULL,
  `match_text` varchar(512) DEFAULT NULL,
  `times_used` int(11) NOT NULL DEFAULT '0',
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `quote`
--

INSERT INTO `quote` (`id`, `author_id`, `quote_text`, `match_text`, `times_used`, `added`) VALUES
(1, 1, 'Dreams will get you nowhere, a good kick in the pants will take you a long way.', 'dreamswillgetyounowhereagoodkickinthepantswilltakeyoualongway', 0, '2017-08-10 13:08:44'),
(2, 2, 'Men can starve from a lack of self-realization as much as they can from a lack of bread.', 'mencanstarvefromalackofselfrealizationasmuchastheycanfromalackofbread', 0, '2017-08-10 13:12:56'),
(3, 3, 'We are not permitted to choose the frame of our destiny. But what we put into it is ours.', 'wearenotpermittedtochoosetheframeofourdestinybutwhatweputintoitisours', 0, '2017-08-10 13:15:41'),
(4, 4, 'The art of living is more like wrestling than dancing.', 'theartoflivingismorelikewrestlingthandancing', 0, '2017-08-10 13:18:21'),
(5, 5, 'If it''s true that our species is alone in the universe, then I''d have to say the universe aimed rather low and settled for very little.', 'ifitstruethatourspeciesisaloneintheuniversethenidhavetosaytheuniverseaimedratherlowandsettledforverylittle', 0, '2017-08-10 14:01:28'),
(6, 6, 'We all know that light travels faster than sound. That''s why certain people appear bright until you hear them speak.', 'weallknowthatlighttravelsfasterthansoundthatswhycertainpeopleappearbrightuntilyouhearthemspeak', 0, '2017-08-10 14:05:59'),
(7, 6, 'If you can''t explain it to a six year old, you don''t understand it yourself.', 'ifyoucantexplainittoasixyearoldyoudontunderstandityourself', 0, '2017-08-10 14:08:04'),
(8, 6, 'If you want your children to be intelligent, read them fairy tales. If you want them to be more intelligent, read them more fairy tales.', 'ifyouwantyourchildrentobeintelligentreadthemfairytalesifyouwantthemtobemoreintelligentreadthemmorefairytales', 0, '2017-08-10 14:11:38'),
(9, 6, 'Logic will get you from A to Z; imagination will get you everywhere.', 'logicwillgetyoufromatozimaginationwillgetyoueverywhere', 0, '2017-08-10 14:12:35'),
(10, 6, 'Anyone who has never made a mistake has never tried anything new.', 'anyonewhohasnevermadeamistakehasnevertriedanythingnew', 0, '2017-08-10 14:14:51'),
(11, 6, 'I speak to everyone in the same way, whether he is the garbage man or the president of the university.', 'ispeaktoeveryoneinthesamewaywhetherheisthegarbagemanorthepresidentoftheuniversity', 0, '2017-08-10 14:16:15'),
(12, 6, 'Never memorize something that you can look up.', 'nevermemorizesomethingthatyoucanlookup', 0, '2017-08-10 14:17:13'),
(13, 6, 'Once you can accept the universe as matter expanding into nothing that is something, wearing stripes with plaid comes easy.', 'onceyoucanaccepttheuniverseasmatterexpandingintonothingthatissomethingwearingstripeswithplaidcomeseasy', 0, '2017-08-10 14:21:56'),
(14, 6, 'If I were not a physicist, I would probably be a musician. I often think in music. I live my daydreams in music. I see my life in terms of music.', 'ifiwerenotaphysicistiwouldprobablybeamusicianioftenthinkinmusicilivemydaydreamsinmusiciseemylifeintermsofmusic', 0, '2017-08-10 14:23:13'),
(15, 6, 'The world as we have created it is a process of our thinking. It cannot be changed without changing our thinking.', 'theworldaswehavecreateditisaprocessofourthinkingitcannotbechangedwithoutchangingourthinking', 0, '2017-08-10 14:24:28'),
(16, 6, 'I know not with what weapons World War III will be fought, but World War IV will be fought with sticks and stones.', 'iknownotwithwhatweaponsworldwariiiwillbefoughtbutworldwarivwillbefoughtwithsticksandstones', 0, '2017-08-10 14:25:49'),
(17, 6, 'You never fail until you stop trying.', 'youneverfailuntilyoustoptrying', 0, '2017-08-10 14:26:38'),
(18, 6, 'Gravitation is not responsible for people falling in love.', 'gravitationisnotresponsibleforpeoplefallinginlove', 0, '2017-08-10 14:28:27'),
(19, 7, 'I can accept failure, everyone fails at something. But I can''t accept not trying.', 'icanacceptfailureeveryonefailsatsomethingbuticantacceptnottrying', 0, '2017-08-10 14:34:48'),
(20, 7, 'Talent wins games, but teamwork and intelligence wins championships.', 'talentwinsgamesbutteamworkandintelligencewinschampionships', 0, '2017-08-10 14:35:33'),
(21, 7, 'Some people want it to happen, some wish it would happen, others make it happen.', 'somepeoplewantittohappensomewishitwouldhappenothersmakeithappen', 0, '2017-08-10 14:36:26'),
(22, 7, 'I''ve failed over and over and over again in my life and that is why I succeed.', 'ivefailedoverandoverandoveragaininmylifeandthatiswhyisucceed', 0, '2017-08-10 14:37:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author`
--
ALTER TABLE `author`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `author_match_text_idx` (`match_text`) USING BTREE;

--
-- Indexes for table `quote`
--
ALTER TABLE `quote`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author`
--
ALTER TABLE `author`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `quote`
--
ALTER TABLE `quote`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
