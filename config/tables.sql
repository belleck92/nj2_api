use nj2;

DROP TABLE IF EXISTS user;
CREATE TABLE user
(
  idUser INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,email VARCHAR(255) COMMENT ''
  ,password VARCHAR(60) COMMENT ''
  ,role INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE UNIQUE INDEX user_email_password_pk ON user (email, password);

DROP TABLE IF EXISTS game;
CREATE TABLE game
(
  idGame INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,currentTurn INT(11) DEFAULT 0 COMMENT ''
  ,maxTurns INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,started INT(1) DEFAULT 0 COMMENT 'If the game is started, no one can create a new player on it'
) ENGINE='InnoDB';

DROP TABLE IF EXISTS player;
CREATE TABLE player
(
   idPlayer INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idUser INT(11) DEFAULT 0 COMMENT ''
  ,idGame INT(11) DEFAULT 0 COMMENT ''
  ,idAlliance INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,treasure INT(11) DEFAULT 0 COMMENT ''
  ,color VARCHAR(20) DEFAULT '' COMMENT ''
  ,capitalCity INT(11) DEFAULT 0 COMMENT ''
  ,lastResolutionEvents TEXT COMMENT 'A JSON describing the last turn events the player can see'
  ,taxRate INT(11) DEFAULT 0 COMMENT 'Percentage, from 0 to 100'
) ENGINE='InnoDB';
CREATE INDEX player_idUser ON player (idUser);
CREATE INDEX player_idGame ON player (idGame);
CREATE INDEX player_idAlliance ON player (idAlliance);

DROP TABLE IF EXISTS hexa;
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
  ,population INT(11) DEFAULT 0 COMMENT 'The exact number of inhabitants in the city. The size of the city come from a formula using this field.'
  ,malusConquest INT(11) DEFAULT 0 COMMENT 'In percent. Malus on production, growth, science, etc... of the city due to recent conquest. Decreases by the time'
) ENGINE='InnoDB';
CREATE INDEX hexa_idGame ON hexa (idGame);
CREATE INDEX hexa_idPlayer ON hexa (idPlayer);
CREATE INDEX hexa_idTypeClimate ON hexa (idTypeClimate);

DROP TABLE IF EXISTS typeClimate;
CREATE TABLE typeClimate
(
  idTypeClimate INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,food INT(11) DEFAULT 0 COMMENT ''
  ,defenseBonus INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS resource;
CREATE TABLE resource
(
  idResource INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX resource_idHexa ON resource (idHexa);
CREATE INDEX resource_idTypeResource ON resource (idTypeResource);

DROP TABLE IF EXISTS typeResource;
CREATE TABLE typeResource
(
   idTypeResource INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS typeResourceBonus;
CREATE TABLE typeResourceBonus
(
   idTypeResourceBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,idBonus INT(11) DEFAULT 0 COMMENT ''
  ,era INT(11) DEFAULT 0 COMMENT 'The era the bonus is active'
) ENGINE='InnoDB';
CREATE INDEX typeResourceBonus_idBonus_pk ON typeResourceBonus (idBonus);
CREATE INDEX typeResourceBonus_idTypeResource_pk ON typeResourceBonus (idTypeResource);

DROP TABLE IF EXISTS stock;
CREATE TABLE stock
(
  idStock INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,qty INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX stock_idTypeResource_pk ON stock (idTypeResource);
CREATE INDEX stock_idHexa_pk ON stock (idHexa);

DROP TABLE IF EXISTS river;
CREATE TABLE river
(
  idRiver INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,side INT(11) DEFAULT 0 COMMENT ''
  ,ford INT(1) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX river_idHexa_pk ON river (idHexa);

DROP TABLE IF EXISTS building;
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

DROP TABLE IF EXISTS palaceBonus;
CREATE TABLE palaceBonus
(
  idPalaceBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBonus INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX palaceBonus_idPlayer ON palaceBonus (idPlayer);
CREATE INDEX palaceBonus_idTypeBonus ON palaceBonus (idTypeBonus);

DROP TABLE IF EXISTS typeBuilding;
CREATE TABLE typeBuilding
(
  idTypeBuilding INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,price INT(11) DEFAULT 0 COMMENT 'Price of the level 1'
  ,buildingTime INT(11) DEFAULT 0 COMMENT 'Time of building for 1 level'
  ,maxLevel INT(11) DEFAULT 0 COMMENT 'Max level, 0 for infinite'
  ,priceCoef INT(11) DEFAULT 0 COMMENT 'level 2 is (1+(priceCoef/100))than level 1 and so on'
  ,maintenancePriceRatio INT(11) DEFAULT 0 COMMENT 'Cost of the building each turn : (maintenancePriceRatio/100)*Total contruction price'
  ,needsPopulation INT(1) DEFAULT 0 COMMENT 'Tells if the building needs some population units to work'
  ,investmentCapacity INT(11) DEFAULT 0 COMMENT 'Gold to be invested in building role, ex : units production'
  ,priorityLevel  INT(11) DEFAULT 0 COMMENT 'When not enough population in the city, priority to get population in slots'
) ENGINE='InnoDB';

DROP TABLE IF EXISTS typeBonus;
CREATE TABLE typeBonus
(
  idTypeBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS hq;
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
  ,isPalaceBonus INT(1) DEFAULT 0 COMMENT 'Bonus usable by the palace'
) ENGINE='InnoDB';
CREATE INDEX hq_idHexa_pk ON hq (idHexa);
CREATE INDEX hq_idPlayer_pk ON hq (idPlayer);

DROP TABLE IF EXISTS typeHq;
CREATE TABLE typeHq
(
  idTypeHq INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS typeMission;
CREATE TABLE typeMission
(
   idTypeMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,unitOrSpy  INT(11) DEFAULT 0 COMMENT '1 : military mission, 2 : Spy mission'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX typeMission_unitOrSpy_pk ON typeMission (unitOrSpy);

DROP TABLE IF EXISTS unit;
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

DROP TABLE IF EXISTS typeUnit;
CREATE TABLE typeUnit
(
   idTypeMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeHq INT(11) DEFAULT 0 COMMENT 'Type of hq (terrestrial, aerial, naval)'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
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

DROP TABLE IF EXISTS typeUnitMission;
CREATE TABLE typeUnitMission
(
  idTypeUnitMission INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeUnit INT(11) DEFAULT 0 COMMENT 'Type of unit'
  ,idTypeMission INT(11) DEFAULT 0 COMMENT 'Type of mission'
) ENGINE='InnoDB' COMMENT 'Types of missions possibles by unit';
CREATE INDEX typeUnitMission_idTypeUnit_pk ON typeUnitMission (idTypeUnit);
CREATE INDEX typeUnitMission_idTypeMission_pk ON typeUnitMission (idTypeMission);

DROP TABLE IF EXISTS trajectory;
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

DROP TABLE IF EXISTS trajectoryHexa;
CREATE TABLE trajectoryHexa
(
  idTrajectoryHexa INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTrajectory INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT ''
  ,rank INT(11) DEFAULT 0 COMMENT 'Rank of the hexa in the trajectory'
) ENGINE='InnoDB';
CREATE INDEX trajectoryHexa_idTrajectory_pk ON trajectoryHexa (idTrajectory);
CREATE INDEX trajectoryHexa_idHexa_pk ON trajectoryHexa (idHexa);

DROP TABLE IF EXISTS caravan;
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

DROP TABLE IF EXISTS spy;
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

DROP TABLE IF EXISTS expert;
CREATE TABLE expert
(
   idExpert INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT 'If 0 : on sale'
  ,idBonus  INT(11) DEFAULT 0 COMMENT ''
  ,idHexa INT(11) DEFAULT 0 COMMENT 'The city where the expert works (destination). If 0 : on sale'
  ,itemsLeft  INT(11) DEFAULT 0 COMMENT 'Number of items left, depending on the role.'
  ,turnsLeft  INT(11) DEFAULT 0 COMMENT 'Number of turns before arrival 1=arrival at next turn resolution.'
) ENGINE='InnoDB';
CREATE INDEX expert_idPlayer_pk ON expert (idPlayer);
CREATE INDEX expert_idBonus_pk ON expert (idBonus);
CREATE INDEX expert_idHexa_pk ON expert (idHexa);

DROP TABLE IF EXISTS typeBonus;
CREATE TABLE typeBonus
(
  idTypeBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS bonus;
CREATE TABLE bonus
(
  idBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeBonus INT(11) DEFAULT 0 COMMENT ''
  ,idTypeBuilding  INT(11) DEFAULT 0 COMMENT 'The building permitted by this bonus or the building type concerned by the investment bonus'
  ,era  INT(11) DEFAULT 0 COMMENT 'The era of the building if the bonus permits a building. The era of the bonus if it\'s a resource bonus'
  ,idTypeResource  INT(11) DEFAULT 0 COMMENT 'The resource permitted by this bonus'
  ,idTypeUnit  INT(11) DEFAULT 0 COMMENT 'The unit permitted by this bonus or the unit type concerned by the investment bonus'
  ,value  INT(11) DEFAULT 0 COMMENT 'Value of the bonus, in percent, if its not a bonus that permits to use an entity'
) ENGINE='InnoDB';
CREATE INDEX bonus_idTypeBonus_pk ON bonus (idTypeBonus);
CREATE INDEX bonus_idTypeBuilding_pk ON bonus (idTypeBuilding);
CREATE INDEX bonus_idTypeResource_pk ON bonus (idTypeResource);
CREATE INDEX bonus_idTypeUnit_pk ON bonus (idTypeUnit);

DROP TABLE IF EXISTS typeTechBonus;
CREATE TABLE typeTechBonus
(
  idTechBonus INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeTech INT(11) DEFAULT 0 COMMENT ''
  ,idBonus INT(11) DEFAULT 0 COMMENT ''
) ENGINE='InnoDB';
CREATE INDEX typeTechBonus_idBonus_pk ON typeTechBonus (idBonus);
CREATE INDEX typeTechBonus_idTypeTech_pk ON typeTechBonus (idTypeTech);

DROP TABLE IF EXISTS typeTech;
CREATE TABLE typeTech
(
  idTypeTech INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTechCategory INT(11) DEFAULT 0 COMMENT ''
  ,idEra INT(11) DEFAULT 0 COMMENT ''
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
  ,idTechCategoryNeeded  INT(11) DEFAULT 0 COMMENT 'Level technology needed to research the tech'
) ENGINE='InnoDB';
CREATE INDEX typeTech_idTechCategoryBonus_pk ON typeTech (idTechCategory);
CREATE INDEX typeTech_idEraBonus_pk ON typeTech (idEra);
CREATE INDEX typeTech_idTechCategoryNeeded_pk ON typeTech (idTechCategoryNeeded);

DROP TABLE IF EXISTS tech;
CREATE TABLE tech
(
  idTech INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idPlayer INT(11) DEFAULT 0 COMMENT ''
  ,totalCost  INT(11) DEFAULT 0 COMMENT ''
  ,alreadyInvested  INT(11) DEFAULT 0 COMMENT 'Id this filed is equal to totalCost, the tech is active'
) ENGINE='InnoDB';
CREATE INDEX tech_idPlayer_pk ON tech (idPlayer);

DROP TABLE IF EXISTS alliance;
CREATE TABLE alliance (
  idAlliance INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,idLeader INT(11) DEFAULT 0 COMMENT 'Id of the leader player'
) ENGINE='InnoDB';
CREATE INDEX alliance_idLeader_pk ON alliance (idLeader);

DROP TABLE IF EXISTS treaty;
CREATE TABLE treaty
(
  idTreaty INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idTypeTreaty INT(11) DEFAULT 0 COMMENT ''
  ,idPlayer1 INT(11) DEFAULT 0 COMMENT 'The player who asks for the treaty'
  ,idPlayer2 INT(11) DEFAULT 0 COMMENT 'The alliance who asks for the treaty'
  ,idAlliance1 INT(11) DEFAULT 0 COMMENT 'The player who answer to the demand of treaty'
  ,idAlliance2 INT(11) DEFAULT 0 COMMENT 'The alliance who answer to the demand of treaty'
  ,state INT(1) DEFAULT 0 COMMENT '0 : currently not accepted (proposed). 1 : accepted'
  ,startingTurn INT(11) DEFAULT 0 COMMENT 'The turn from when the treaty is active'
  ,amount INT(11) DEFAULT 0 COMMENT 'In case of a tribute, amount by turn. The player 2 pays to player one'
  ,turnsLeft INT(11) DEFAULT '' COMMENT 'Number of turns left for the tribute'
) ENGINE='InnoDB';
CREATE INDEX treaty_idTypeTreaty_pk ON treaty (idTypeTreaty);
CREATE INDEX treaty_idPlayer1_pk ON treaty (idPlayer1);
CREATE INDEX treaty_idPlayer2_pk ON treaty (idPlayer2);
CREATE INDEX treaty_idAlliance1_pk ON treaty (idAlliance1);
CREATE INDEX treaty_idAlliance2_pk ON treaty (idAlliance2);

DROP TABLE IF EXISTS typeTreaty;
CREATE TABLE typeTreaty
(
  idTypeTreaty INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,name VARCHAR(255) DEFAULT '' COMMENT ''
  ,description TEXT COMMENT ''
  ,fctId VARCHAR(255) DEFAULT '' COMMENT ''
) ENGINE='InnoDB';

DROP TABLE IF EXISTS sale;
CREATE TABLE sale
(
  idSale INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT COMMENT 'Primary key'
  ,idHexa INT(11) DEFAULT 0 COMMENT 'Origin Hexa of the sale'
  ,price INT(11) DEFAULT 0 COMMENT 'Sale price'
  ,idTypeResource INT(11) DEFAULT 0 COMMENT ''
  ,qty INT(11) DEFAULT 0 COMMENT 'Qty, in case of a resource'
  ,idExpert  INT(11) DEFAULT 0 COMMENT 'For experts sales'
  ,idTypeTech  INT(11) DEFAULT 0 COMMENT 'For tech sales'
  ,citySale  INT(1) DEFAULT 0 COMMENT 'For city sales'
  ,idUnit  INT(11) DEFAULT 0 COMMENT 'For unit sales'
  ,idSpy  INT(11) DEFAULT 0 COMMENT 'For prisonners'
) ENGINE='InnoDB';
