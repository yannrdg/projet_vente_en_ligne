--
-- Structure de la table `CONTENIR`
--

CREATE TABLE `CONTENIR` (
  `idp` int(11) NOT NULL,
  `ref` char(5) NOT NULL,
  `quantite` int(11) DEFAULT NULL,
  `prix` float NOT NULL,
  `prixTotal` double NOT NULL
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
  `nom` varchar(100) DEFAULT NULL,
  `descriptif` varchar(255) DEFAULT NULL,
  `prix` float NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(100) DEFAULT NULL
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
  `idp` int(5) NOT NULL,
  `login` varchar(20) DEFAULT NULL,
  `mdp` varchar(255) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `rue` varchar(100) DEFAULT NULL,
  `cp` char(5) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
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
  ADD PRIMARY KEY (`idp`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `VISITEUR`
--
ALTER TABLE `VISITEUR`
  MODIFY `idp` int(5) NOT NULL AUTO_INCREMENT;
