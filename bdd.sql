
--
-- Structure de la table `CONTENIR`
--

CREATE TABLE `CONTENIR` (
  `idp` int(11) NOT NULL,
  `ref` char(5) NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `PANIERCDE`
--

CREATE TABLE `PANIERCDE` (
  `idp` int(11) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `dt` char(10) DEFAULT NULL,
  `statut` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `PRODUIT`
--

CREATE TABLE `PRODUIT` (
  `ref` char(5) NOT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `descriptif` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `VISITER`
--

CREATE TABLE `VISITER` (
  `login` varchar(20) DEFAULT NULL,
  `idpage` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `VISITEUR`
--

CREATE TABLE `VISITEUR` (
  `login` varchar(20) NOT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `rue` varchar(20) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` varchar(20) DEFAULT NULL,
  `cb` char(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `CONTENIR`
--
ALTER TABLE `CONTENIR`
  ADD PRIMARY KEY (`idp`,`ref`);

--
-- Index pour la table `PANIERCDE`
--
ALTER TABLE `PANIERCDE`
  ADD PRIMARY KEY (`idp`);

--
-- Index pour la table `PRODUIT`
--
ALTER TABLE `PRODUIT`
  ADD PRIMARY KEY (`ref`);

--
-- Index pour la table `VISITEUR`
--
ALTER TABLE `VISITEUR`
  ADD PRIMARY KEY (`login`);