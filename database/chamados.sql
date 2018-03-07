CREATE DATABASE  IF NOT EXISTS `chamados` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `chamados`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: chamados
-- ------------------------------------------------------
-- Server version	5.6.25-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assunto`
--

DROP TABLE IF EXISTS `assunto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assunto` (
  `id_assunto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) unsigned NOT NULL,
  `descricao_assunto` varchar(50) NOT NULL,
  `status_assunto` tinyint(3) unsigned NOT NULL,
  `sla` int(10) unsigned NOT NULL,
  `alerta_chamado` varchar(200) NOT NULL,
  `formato_chamado` tinytext NOT NULL,
  `url_chamado_externo` varchar(200) NOT NULL,
  PRIMARY KEY (`id_assunto`),
  KEY `FK_assunto_grupo_idx` (`id_grupo`),
  KEY `IDX_descricao_assunto` (`descricao_assunto`(5)),
  KEY `IDX_id_grupo` (`id_grupo`),
  KEY `IDX_status_assunto` (`status_assunto`),
  CONSTRAINT `FK_assunto_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chamado`
--

DROP TABLE IF EXISTS `chamado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamado` (
  `id_chamado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_assunto` int(10) unsigned NOT NULL,
  `id_usuario_origem` int(10) unsigned NOT NULL,
  `id_usuario_destino` int(10) unsigned NOT NULL,
  `id_grupo_destino` int(10) unsigned NOT NULL,
  `id_usuario_fechador` int(10) unsigned NOT NULL,
  `codigo_prioridade` int(10) unsigned NOT NULL,
  `descricao_chamado` text NOT NULL,
  `justificativa_prioridade` text NOT NULL,
  `status_chamado` tinyint(3) unsigned NOT NULL,
  `data_abertura` datetime NOT NULL,
  `data_prazo` datetime NOT NULL,
  `data_fechamento` datetime DEFAULT NULL,
  `status_email` tinyint(3) unsigned NOT NULL,
  `email_contato` varchar(250) DEFAULT NULL,
  `codigo_chamado_externo` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_chamado`),
  KEY `FK_chamado_assunto_idx` (`id_assunto`),
  KEY `FK_chamado_grupo_idx` (`id_grupo_destino`),
  KEY `FK_chamado_usuario_idx` (`id_usuario_origem`),
  KEY `IDX_id_grupo_destino` (`id_grupo_destino`),
  KEY `IDX_id_assunto` (`id_assunto`),
  KEY `IDX_id_usuario_origem` (`id_usuario_origem`),
  KEY `IDX_id_usuario_destino` (`id_usuario_destino`),
  KEY `IDX_id_usuario_fechador` (`id_usuario_fechador`),
  KEY `IDX_status_chamado` (`status_chamado`),
  KEY `IDX_data_abertura` (`data_abertura`),
  KEY `IDX_data_prazo` (`data_prazo`),
  KEY `IDX_data_fechamento` (`data_fechamento`),
  CONSTRAINT `FK_chamado_assunto` FOREIGN KEY (`id_assunto`) REFERENCES `assunto` (`id_assunto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_chamado_grupo` FOREIGN KEY (`id_grupo_destino`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_chamado_usuario` FOREIGN KEY (`id_usuario_origem`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `encaminhamento`
--

DROP TABLE IF EXISTS `encaminhamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encaminhamento` (
  `id_encaminhamento` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chamado` int(10) unsigned NOT NULL,
  `id_usuario_origem` int(10) unsigned NOT NULL,
  `id_grupo_destino` int(10) unsigned NOT NULL,
  `id_usuario_destino` int(10) unsigned NOT NULL,
  `data_encaminhamento` datetime NOT NULL,
  PRIMARY KEY (`id_encaminhamento`),
  KEY `FK_encaminhamentos_grupos_idx` (`id_grupo_destino`),
  KEY `FK_encaminhamentos_usuarios_idx` (`id_usuario_origem`),
  KEY `IDX_id_chamado` (`id_chamado`),
  CONSTRAINT `FK_encaminhamentos_grupos` FOREIGN KEY (`id_grupo_destino`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_encaminhamentos_usuarios` FOREIGN KEY (`id_usuario_origem`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `feriado`
--

DROP TABLE IF EXISTS `feriado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `feriado` (
  `id_feriado` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) unsigned NOT NULL,
  `data_feriado` date NOT NULL,
  `descricao_feriado` varchar(100) NOT NULL,
  PRIMARY KEY (`id_feriado`),
  UNIQUE KEY `UN_feriado_grupo_data` (`id_grupo`,`data_feriado`),
  KEY `FK_feriado_grupo_idx` (`id_grupo`),
  KEY `IDX_id_grupo` (`id_grupo`),
  KEY `IDX_data_feriado` (`data_feriado`),
  CONSTRAINT `FK_feriado_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `grupo`
--

DROP TABLE IF EXISTS `grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo` (
  `id_grupo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao_grupo` varchar(50) NOT NULL,
  `email_grupo` varchar(100) NOT NULL,
  `status_grupo` tinyint(10) unsigned NOT NULL,
  `flag_recebe_chamado` tinyint(10) unsigned NOT NULL,
  PRIMARY KEY (`id_grupo`),
  KEY `IDX_status_grupo` (`status_grupo`),
  KEY `IDX_flag_recebe_chamado` (`flag_recebe_chamado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `grupo_usuario`
--

DROP TABLE IF EXISTS `grupo_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `grupo_usuario` (
  `id_grupo` int(10) unsigned NOT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  `flag_admin` tinyint(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_usuario`,`id_grupo`),
  KEY `FK_grupo_usuario_grupo_idx` (`id_grupo`),
  KEY `IDX_flag_admin` (`flag_admin`),
  CONSTRAINT `FK_grupo_usuario_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_grupo_usuario_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historico`
--

DROP TABLE IF EXISTS `historico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico` (
  `id_historico` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_chamado` int(10) unsigned NOT NULL,
  `id_usuario` int(10) unsigned NOT NULL,
  `tipo_historico` smallint(10) unsigned NOT NULL,
  `descricao_historico` text NOT NULL,
  `data_historico` datetime NOT NULL,
  `nome_arquivo_anexo` varchar(100) NOT NULL,
  `caminho_arquivo_anexo` varchar(100) NOT NULL,
  PRIMARY KEY (`id_historico`),
  KEY `FK_historico_usuario_idx` (`id_usuario`),
  KEY `IDX_id_chamado` (`id_chamado`),
  KEY `IDX_id_usuario` (`id_usuario`),
  KEY `IDX_tipo_historico` (`tipo_historico`),
  CONSTRAINT `FK_historico_chamado` FOREIGN KEY (`id_chamado`) REFERENCES `chamado` (`id_chamado`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_historico_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `id_horario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_grupo` int(10) unsigned NOT NULL,
  `dia_semana` tinyint(10) unsigned NOT NULL,
  `inicio_horario` time NOT NULL,
  `termino_horario` time NOT NULL,
  PRIMARY KEY (`id_horario`),
  KEY `FK_horario_horario_idx` (`id_grupo`),
  KEY `IDX_id_grupo` (`id_grupo`),
  KEY `IDX_dia_semana` (`dia_semana`),
  CONSTRAINT `FK_horario_horario` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `setor`
--

DROP TABLE IF EXISTS `setor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setor` (
  `id_setor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descricao_setor` varchar(50) NOT NULL,
  `codigo_centro_custo` varchar(10) NOT NULL,
  `status_setor` tinyint(10) unsigned NOT NULL,
  PRIMARY KEY (`id_setor`),
  KEY `IDX_status_setor` (`status_setor`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id_usuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `nome_usuario` varchar(100) NOT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `id_setor` int(10) unsigned NOT NULL,
  `ramal` varchar(25) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `data_alteracao` datetime NOT NULL,
  `data_ultimo_login` datetime NOT NULL,
  `status_usuario` tinyint(10) unsigned NOT NULL,
  `flag_super_admin` tinyint(10) unsigned NOT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  KEY `FK_usuario_setor_idx` (`id_setor`),
  KEY `IDX_nome_usuario` (`nome_usuario`(5)),
  KEY `IDX_login` (`login`),
  CONSTRAINT `FK_usuario_setor` FOREIGN KEY (`id_setor`) REFERENCES `setor` (`id_setor`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-06 20:57:28
