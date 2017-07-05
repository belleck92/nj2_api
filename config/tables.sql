CREATE TABLE user
(
  idUser INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,email VARCHAR(255) COMMENT ''
  ,password VARCHAR(60) COMMENT ''
  ,role INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE UNIQUE INDEX user_email_password_pk ON user (email, password);

CREATE TABLE game
(
  idGame INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,currentTurn INT(11) DEFAULT 0 COMMENT ''
  ,maxTurns INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,started INT(1) DEFAULT 0 COMMENT 'If the game is started, no one can create a new player on it'
) ENGINE='InnoDB';

CREATE TABLE player
(
   idPlayer INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idUser INT(11) DEFAULT 0 COMMENT ''
  ,idGame INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,treasure INT(11) DEFAULT 0 COMMENT ''
  ,color VARCHAR(20) DEFAULT '' COMMENT ''
  ,capitalCity INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX player_idUser ON player (idUser);
CREATE INDEX player_idGame ON player (idGame);

CREATE TABLE hexa
(
  idHexa INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idGame INT(11) DEFAULT 0 COMMENT ''
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTerritory INT(11) DEFAULT 0 COMMENT ''
  ,idTypeClimate INT(11) DEFAULT 0 COMMENT ''
  ,X INT(11) DEFAULT 0 COMMENT ''
  ,Y INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,population INT(11) DEFAULT 0 COMMENT 'Population * 1000 (for decimals)'
) ENGINE='InnoDB';
CREATE INDEX hexa_idGame ON hexa (idGame);
CREATE INDEX hexa_idPlayer ON hexa (idPlayer);
CREATE INDEX hexa_idTypeClimate ON hexa (idTypeClimate);

CREATE TABLE typeClimate
(
  idTypeClimate INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,food INT(11) DEFAULT 0 COMMENT ''
  ,defenseBonus INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';

CREATE TABLE resource
(
  idResource INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX resource_idHexa ON resource (idHexa);
CREATE INDEX resource_idTypeResource ON resource (idTypeResource);

CREATE TABLE typeResource
(
   idTypeResource INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

CREATE TABLE stock
(
  idStock INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,qty INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX stock_idTypeResource_pk ON stock (idTypeResource);
CREATE INDEX stock_idHexa_pk ON stock (idHexa);

CREATE TABLE river
(
  idRiver INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,side INT(11) DEFAULT 0 COMMENT ''
  ,ford INT(1) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX river_idHexa_pk ON river (idHexa);

CREATE TABLE building
(
  idBuilding INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBuilding INT(11) DEFAULT 0 COMMENT ''
  ,actualLevel INT(11) DEFAULT 0 COMMENT ''
  ,buildingTurnsLeft INT(11) DEFAULT 0 COMMENT 'When not on 0 the building is currently in construction to the actualLevel+1'
  ,populationWorking  INT(11) DEFAULT 0 COMMENT 'Number of population working in the building'
) ENGINE='InnoDB';
CREATE INDEX building_idHexa_pk ON building (idHexa);
CREATE INDEX building_idTypeBuilding_pk ON building (idTypeBuilding);

CREATE TABLE palaceBonus
(
  idPalaceBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBonus INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX palaceBonus_idPlayer ON palaceBonus (idPlayer);
CREATE INDEX palaceBonus_idTypeBonus ON palaceBonus (idTypeBonus);

CREATE TABLE typeBuilding
(
  idTypeBuilding INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,price INT(11) DEFAULT 0 COMMENT 'Price of the level 1'
  ,buildingTime INT(11) DEFAULT 0 COMMENT 'Time of building for 1 level'
  ,maxLevel INT(11) DEFAULT 0 COMMENT 'Max level, 0 for infinite'
  ,priceCoef INT(11) DEFAULT 0 COMMENT 'level 2 is (1+(priceCoef/100))than level 1 and so on'
  ,maintenancePriceRatio INT(11) DEFAULT 0 COMMENT 'Cost of the building each turn : (maintenancePriceRatio/100)*Total contruction price'
  ,needsPopulation INT(1) DEFAULT 0 COMMENT 'Tells if the building needs some population units to work'
  ,investmentCapacity INT(11) DEFAULT 0 COMMENT 'Gold to be invested in building role, ex : units production'
  ,idTypeBonus INT(11) DEFAULT 0 COMMENT 'Bonus permitted by the building'
  ,BonusValue INT(11) DEFAULT 0 COMMENT 'If bonus set, value of the bonus, per level'
  ,priorityLevel  INT(11) DEFAULT 0 COMMENT 'When not enough population in the city, '
) ENGINE='InnoDB';
CREATE INDEX typeBuilding_idTypeBonus ON typeBuilding (idTypeBonus);

CREATE TABLE typeBonus
(
  idTypeBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

CREATE TABLE hq
(
   idHq INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTypeMission INT(11) DEFAULT 0 COMMENT 'Id of the mission type'
  ,idTypeHq INT(11) DEFAULT 0 COMMENT 'Type of hq (terrestrial, aerial, naval)'
  ,idTarget INT(11) DEFAULT 0 COMMENT 'Id of the target of the mission'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,level INT(11) DEFAULT 0 COMMENT 'Level of the hq'
  ,capop INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX hq_idHexa_pk ON hq (idHexa);
CREATE INDEX hq_idPlayer_pk ON hq (idPlayer);
CREATE INDEX building_idTypeBuilding_pk ON building (idTypeBuilding);

CREATE TABLE typeHq
(
  idTypeHq INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

CREATE TABLE typeMission
(
   idTypeMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,unitOrSpy  INT(11) DEFAULT 0 COMMENT '1 : military mission, 2 : Spy mission'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX typeMission_unitOrSpy_pk ON typeMission (unitOrSpy);

CREATE TABLE unit
(
  idUnit INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeUnit INT(11) DEFAULT 0 COMMENT 'Type of unit'
  ,idHq INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT 'The hexa where the unit is being produced'
  ,buildingTurnsLeft INT(11) DEFAULT 0 COMMENT 'When not on 0 the unit is currently in construction'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,morale VARCHAR(255) DEFAULT '' COMMENT ''
  ,xp INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX unit_idHq_pk ON unit (idHq);

CREATE TABLE typeUnit
(
   idTypeMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeHq INT(11) DEFAULT 0 COMMENT 'Type of hq (terrestrial, aerial, naval)'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT DEFAULT '' COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,assault INT(11) DEFAULT 0 COMMENT ''
  ,resistance INT(11) DEFAULT 0 COMMENT ''
  ,mvt INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBuilding INT(11) DEFAULT 0 COMMENT 'The building necessary to build the unit'
  ,zIndex INT(11) DEFAULT 0 COMMENT 'Priority for displaying in a unit stack. Much is better'
  ,mecanized INT(1) DEFAULT 0 COMMENT ''
  ,motorized INT(1) DEFAULT 0 COMMENT ''
  ,visionRange INT(11) DEFAULT 0 COMMENT ''
  ,price INT(11) DEFAULT 0 COMMENT ''
  ,buildingTime INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX typeUnit_idTypeHq_pk ON typeUnit (idTypeHq);

CREATE TABLE typeUnitMission
(
  idTypeUnitMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeUnit INT(11) DEFAULT 0 COMMENT 'Type of unit'
  ,idTypeMission INT(11) DEFAULT 0 COMMENT 'Type of mission'
) ENGINE='InnoDB' COMMENT 'Types of missions possibles by unit';
CREATE INDEX typeUnitMission_idTypeUnit_pk ON typeUnitMission (idTypeUnit);
CREATE INDEX typeUnitMission_idTypeUnit_pk ON typeUnitMission (idTypeUnit);

CREATE TABLE trajectory
(
  idTrajectory INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHq INT(11) DEFAULT 0 COMMENT ''
  ,idSpy INT(11) DEFAULT 0 COMMENT ''
  ,idCaravan INT(11) DEFAULT 0 COMMENT ''
  ,idExpert INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX trajectory_idHq_pk ON trajectory (idHq);
CREATE INDEX trajectory_idSpy_pk ON trajectory (idSpy);
CREATE INDEX trajectory_idCaravan_pk ON trajectory (idCaravan);
CREATE INDEX trajectory_idExpert_pk ON trajectory (idExpert);

CREATE TABLE trajectoryHexa
(
  idTrajectoryHexa INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTrajectory INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,rank INT(11) DEFAULT 0 COMMENT 'Rank of the hexa in the trajectory'
) ENGINE='InnoDB';
CREATE INDEX trajectoryHexa_idTrajectory_pk ON trajectoryHexa (idTrajectory);
CREATE INDEX trajectoryHexa_idHexa_pk ON trajectoryHexa (idHexa);

CREATE TABLE caravan
(
  idCaravan INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTypeRessource  INT(11) DEFAULT 0 COMMENT ''
  ,qty  INT(11) DEFAULT 0 COMMENT ''
  ,turnsLeft  INT(11) DEFAULT 0 COMMENT 'Number of turns before arrival 1=arrival at next turn resolution'
) ENGINE='InnoDB';
CREATE INDEX caravan_idPlayer_pk ON caravan (idPlayer);
CREATE INDEX caravan_idTypeRessource_pk ON caravan (idTypeRessource);

CREATE TABLE spy
(
   idSpy INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,idTypeMission INT(11) DEFAULT 0 COMMENT 'Id of the mission type'
  ,idTarget INT(11) DEFAULT 0 COMMENT 'Id of the target of the mission'
  ,infiltrated INT(1) DEFAULT 0 COMMENT 'Tells if the spy is infiltrated in the city where he has a mission'
  ,turnsLeft  INT(11) DEFAULT 0 COMMENT 'Number of turns before arrival 1=arrival at next turn resolution'
) ENGINE='InnoDB';
CREATE INDEX spy_idPlayer_pk ON spy (idPlayer);
CREATE INDEX spy_idHexa_pk ON spy (idHexa);
CREATE INDEX spy_idTypeMission_pk ON spy (idTypeMission);

CREATE TABLE expert
(
   idExpert INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBonus  INT(11) DEFAULT 0 COMMENT ''
  ,idTypeUnit  INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBuilding  INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT 'The city where the expert works (destination)'
  ,itemsLeft  INT(11) DEFAULT 0 COMMENT 'Number of items left, depending on the role'
  ,turnsLeft  INT(11) DEFAULT 0 COMMENT 'Number of turns before arrival 1=arrival at next turn resolution'
) ENGINE='InnoDB';
CREATE INDEX expert_idPlayer_pk ON expert (idPlayer);
CREATE INDEX expert_idTypeBonus_pk ON expert (idTypeBonus);
CREATE INDEX expert_idTypeBuilding_pk ON expert (idTypeBuilding);
CREATE INDEX expert_idHexa_pk ON expert (idHexa);