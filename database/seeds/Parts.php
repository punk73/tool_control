<?php

use Illuminate\Database\Seeder;
use App\Part;
use App\Supplier;


class Parts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = Supplier::all();

		$pck31s = [
		    [
		      "part_no"=> "A6D-0105-00",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "GE35694-001A",
		      "part_name"=> "SOURCEBUTTON"
		    ],
		    [
		      "part_no"=> "A2B-0103-04",
		      "part_name"=> "DRESSINGPANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-18",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-1F",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "GE20379-003A",
		      "part_name"=> "RIMCOVER"
		    ],
		    [
		      "part_no"=> "LV11896-009ANK",
		      "part_name"=> "DRESSINGPANEL"
		    ],
		    [
		      "part_no"=> "LV23077-001ANK",
		      "part_name"=> "HOMEBUTTON"
		    ],
		    [
		      "part_no"=> "LV23078-001ANK",
		      "part_name"=> "SERCHBUTTON"
		    ],
		    [
		      "part_no"=> "LV23079-001ANK",
		      "part_name"=> "VOLBUTTON"
		    ],
		    [
		      "part_no"=> "E6J-0003-009",
		      "part_name"=> "JACKOTHERS"
		    ],
		    [
		      "part_no"=> "L7H-0098-009",
		      "part_name"=> "TCXO"
		    ],
		    [
		      "part_no"=> "L7J-0026-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0029-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0054-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0099-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "CD04AT1H4R7M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "J7J-0022-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0286-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "EC720AT-0514A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "LB73G0DY-0049",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0EA-0029",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0EB-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0ED-0029",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0ED-0039",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "NJM2855DL1-339",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2884U2-058",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJM2884U2-338",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "FZA10BF-2R09",
		      "part_name"=> "FUSE"
		    ],
		    [
		      "part_no"=> "DAP202UM9",
		      "part_name"=> "DIODE"
		    ],
		    [
		      "part_no"=> "ML22Q394714MB9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "ML86251LAZ07F7",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "RB160MM-309",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB161MM-209",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "UDZV11B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV15B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV16B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "2SAR512P58",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "CK73FXR1E106K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73GXR1E225K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HXR1E333K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730AT1A823K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "LK73H0AM33NJ9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "TC7SET04FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SET32FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH125FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH126FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SZ125FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "D13-3102-14",
		      "part_name"=> "ROLLERGEAR"
		    ],
		    [
		      "part_no"=> "D13-3103-04",
		      "part_name"=> "WORMGEAR1"
		    ],
		    [
		      "part_no"=> "D13-3104-04",
		      "part_name"=> "HELICALGEAR1"
		    ],
		    [
		      "part_no"=> "D13-3105-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "D13-3106-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "D13-3107-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "D13-3108-04",
		      "part_name"=> "JOINTGEAR"
		    ],
		    [
		      "part_no"=> "D13-3109-04",
		      "part_name"=> "WORM"
		    ],
		    [
		      "part_no"=> "D13-3110-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "D13-3111-04",
		      "part_name"=> "LOADGEARV"
		    ],
		    [
		      "part_no"=> "D13-3112-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "D13-3113-04",
		      "part_name"=> "GEAR"
		    ],
		    [
		      "part_no"=> "J7K-0227-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "A6D-0059-02",
		      "part_name"=> "PANELASSY"
		    ],
		    [
		      "part_no"=> "A6D-0059-03",
		      "part_name"=> "PANELASSY"
		    ],
		    [
		      "part_no"=> "A6D-0059-04",
		      "part_name"=> "PANELASSY"
		    ],
		    [
		      "part_no"=> "K2E-0038-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "K2K-0184-00",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "D14-1043-04",
		      "part_name"=> "ROLLER"
		    ],
		    [
		      "part_no"=> "LV39934-001A",
		      "part_name"=> "DAMPER"
		    ],
		    [
		      "part_no"=> "LV39934-002A",
		      "part_name"=> "DAMPER"
		    ],
		    [
		      "part_no"=> "LV45724-001A",
		      "part_name"=> "RUBBERROLLER"
		    ],
		    [
		      "part_no"=> "B4A-1168-00",
		      "part_name"=> "NAMEPLATE"
		    ],
		    [
		      "part_no"=> "E3A-0302-00",
		      "part_name"=> "CORDWITHPLUG"
		    ],
		    [
		      "part_no"=> "E3A-0363-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0381-00",
		      "part_name"=> "DCCORD"
		    ],
		    [
		      "part_no"=> "E3A-0382-00",
		      "part_name"=> "DCCORD"
		    ],
		    [
		      "part_no"=> "E3A-0421-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0424-00",
		      "part_name"=> "CORDW.PINJACK"
		    ],
		    [
		      "part_no"=> "E3A-0483-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0524-00",
		      "part_name"=> "DCCORD"
		    ],
		    [
		      "part_no"=> "QAN0126-001",
		      "part_name"=> "MICROPHONE"
		    ],
		    [
		      "part_no"=> "W0C-0322-00",
		      "part_name"=> "TOUCHPANEL"
		    ],
		    [
		      "part_no"=> "W0C-0323-00",
		      "part_name"=> "TOUCHPANEL"
		    ],
		    [
		      "part_no"=> "W0C-0328-00",
		      "part_name"=> "TOUCHPANEL"
		    ],
		    [
		      "part_no"=> "W0C-0329-00",
		      "part_name"=> "TOUCHPANEL"
		    ],
		    [
		      "part_no"=> "E3A-0537-00",
		      "part_name"=> "DCCORD"
		    ],
		    [
		      "part_no"=> "E3A-0556-00",
		      "part_name"=> "USBCORD"
		    ],
		    [
		      "part_no"=> "G0A-0079-00",
		      "part_name"=> "COMP.SPRING"
		    ],
		    [
		      "part_no"=> "B5A-2145-10",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2145-12",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-10",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-11",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-12",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-13",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-14",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-15",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-16",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-17",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2146-18",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2147-01",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2147-02",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2147-03",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2300-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2369-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2370-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2371-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2372-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2485-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2485-01",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2485-02",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2508-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5E-0170-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5E-0171-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5E-0172-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5E-0173-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5E-0174-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5H-0202-00",
		      "part_name"=> "SUB-INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5H-0238-00",
		      "part_name"=> "SUB-INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5H-0246-00",
		      "part_name"=> "SUB-INST.MANUAL"
		    ],
		    [
		      "part_no"=> "F0K-0047-06",
		      "part_name"=> "SHEET"
		    ],
		    [
		      "part_no"=> "F1C-0101-07",
		      "part_name"=> "CONDUCTSHEET"
		    ],
		    [
		      "part_no"=> "F1C-0137-00",
		      "part_name"=> "SHIELDINGSHEET"
		    ],
		    [
		      "part_no"=> "F2A-0072-00",
		      "part_name"=> "INS.SHEET"
		    ],
		    [
		      "part_no"=> "G1D-0034-0Y",
		      "part_name"=> "CONDUCTCUSHION"
		    ],
		    [
		      "part_no"=> "G1D-0034-0Z",
		      "part_name"=> "CONDUCTCUSHION"
		    ],
		    [
		      "part_no"=> "E2D-0011-009",
		      "part_name"=> "GROUNDTERMINAL"
		    ],
		    [
		      "part_no"=> "A8A-0042-0W",
		      "part_name"=> "REARPANEL"
		    ],
		    [
		      "part_no"=> "A8A-0045-01",
		      "part_name"=> "REARPANEL"
		    ],
		    [
		      "part_no"=> "A8A-0048-16",
		      "part_name"=> "REARPANEL"
		    ],
		    [
		      "part_no"=> "J2B-0388-00",
		      "part_name"=> "BRACKETASSY"
		    ],
		    [
		      "part_no"=> "LV23004-004A",
		      "part_name"=> "SLIDER"
		    ],
		    [
		      "part_no"=> "LV23005-001A",
		      "part_name"=> "GEARHOLDER"
		    ],
		    [
		      "part_no"=> "LV38961-002A",
		      "part_name"=> "HCTURNTABLE"
		    ],
		    [
		      "part_no"=> "LV39938-001A",
		      "part_name"=> "GEARRETAINER"
		    ],
		    [
		      "part_no"=> "LV45718-001A",
		      "part_name"=> "ROLLERRETAINER"
		    ],
		    [
		      "part_no"=> "LV11685-004A",
		      "part_name"=> "TOPFRAME"
		    ],
		    [
		      "part_no"=> "LV11686-003A",
		      "part_name"=> "BOTTOMFRAME"
		    ],
		    [
		      "part_no"=> "LV11690-001A",
		      "part_name"=> "ROLLERARM"
		    ],
		    [
		      "part_no"=> "LV11836-006A",
		      "part_name"=> "ROLLERARM"
		    ],
		    [
		      "part_no"=> "LV11839-004A",
		      "part_name"=> "GEARBKT"
		    ],
		    [
		      "part_no"=> "LV11878-004A",
		      "part_name"=> "LOWERCHASSIS"
		    ],
		    [
		      "part_no"=> "LV22830-002A",
		      "part_name"=> "T.MBASEASSY"
		    ],
		    [
		      "part_no"=> "LV23002-001A",
		      "part_name"=> "TMCOVERMAIN"
		    ],
		    [
		      "part_no"=> "LV3A173-001A",
		      "part_name"=> "JOINTLEVER"
		    ],
		    [
		      "part_no"=> "LV39922-001A",
		      "part_name"=> "TMCOVERSUB"
		    ],
		    [
		      "part_no"=> "LV39923-002A",
		      "part_name"=> "UDLEVER"
		    ],
		    [
		      "part_no"=> "LV39937-003A",
		      "part_name"=> "TMCHASSISASSY"
		    ],
		    [
		      "part_no"=> "A1A-0015-01",
		      "part_name"=> "CHASSIS"
		    ],
		    [
		      "part_no"=> "A1A-0015-03",
		      "part_name"=> "CHASSIS"
		    ],
		    [
		      "part_no"=> "E0E-0008-007",
		      "part_name"=> "RFC.RECEPTACLE"
		    ],
		    [
		      "part_no"=> "LV23055-003A",
		      "part_name"=> "ROLLERLEVER"
		    ],
		    [
		      "part_no"=> "LV23059-003A",
		      "part_name"=> "MDCHASSISASSY"
		    ],
		    [
		      "part_no"=> "LV11842-004A",
		      "part_name"=> "DISCGUIDE"
		    ],
		    [
		      "part_no"=> "LV11881-002A",
		      "part_name"=> "GEARHOLDER"
		    ],
		    [
		      "part_no"=> "LV23003-002A",
		      "part_name"=> "ROLLERHOLDER"
		    ],
		    [
		      "part_no"=> "LV23057-001A",
		      "part_name"=> "SLIDERR"
		    ],
		    [
		      "part_no"=> "LV23058-001A",
		      "part_name"=> "SLIDERL"
		    ],
		    [
		      "part_no"=> "LV3A174-002A",
		      "part_name"=> "DISCARML"
		    ],
		    [
		      "part_no"=> "LV3A175-001A",
		      "part_name"=> "DISCARMR"
		    ],
		    [
		      "part_no"=> "LV3A178-001A",
		      "part_name"=> "TRIGGERSLIDER"
		    ],
		    [
		      "part_no"=> "LV36813-301A",
		      "part_name"=> "SUBGUIDECAP"
		    ],
		    [
		      "part_no"=> "LV37652-002A",
		      "part_name"=> "SHAFTGUIDE"
		    ],
		    [
		      "part_no"=> "LV39932-003A",
		      "part_name"=> "TRIGGERSLIDER"
		    ],
		    [
		      "part_no"=> "LV45795-003A",
		      "part_name"=> "R.RETAINERR"
		    ],
		    [
		      "part_no"=> "LV45796-001A",
		      "part_name"=> "R.RETAINERL"
		    ],
		    [
		      "part_no"=> "H0B-0377-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H0B-0378-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H0B-0381-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H0B-0384-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H0B-0391-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H0D-0344-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H0D-0345-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H0D-0348-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H0D-0351-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H0D-0358-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1218-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1229-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1272-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1276-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1286-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1289-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1294-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "H6A-1297-00",
		      "part_name"=> "OUTERCARTON"
		    ],
		    [
		      "part_no"=> "B46-0827-00",
		      "part_name"=> "WARRANTYCARD"
		    ],
		    [
		      "part_no"=> "B5A-2298-00",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2298-01",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "B5A-2298-02",
		      "part_name"=> "INST.MANUAL"
		    ],
		    [
		      "part_no"=> "H5A-1186-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H5A-1199-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H5A-1371-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H5A-1376-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H5A-1394-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "H5A-1397-00",
		      "part_name"=> "ITEMCARTON"
		    ],
		    [
		      "part_no"=> "K2A-0001-02",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0019-19",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0020-0B",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0020-10",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0020-15",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0020-23",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0021-08",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0021-09",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2A-0066-00",
		      "part_name"=> "KNOB"
		    ],
		    [
		      "part_no"=> "K2K-0235-00",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0235-01",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0235-02",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0236-1A",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0236-16",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0236-18",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0237-03",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0238-13",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0239-15",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0239-16",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0240-10",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "K2K-0270-00",
		      "part_name"=> "KEYTOP"
		    ],
		    [
		      "part_no"=> "A2C-0044-00",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A2C-0044-02",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A4G-0071-00",
		      "part_name"=> "REARCOVER"
		    ],
		    [
		      "part_no"=> "A6C-0079-10",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0014-06",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0100-11",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0100-12",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "B0H-0001-00",
		      "part_name"=> "ESCUTCHEON"
		    ],
		    [
		      "part_no"=> "B1K-0037-00",
		      "part_name"=> "LIGHTINGBOARD"
		    ],
		    [
		      "part_no"=> "B1K-0096-10",
		      "part_name"=> "LIGHTINGBOARD"
		    ],
		    [
		      "part_no"=> "D1A-0022-00",
		      "part_name"=> "LEVER"
		    ],
		    [
		      "part_no"=> "K2F-0050-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "LV11908-020A",
		      "part_name"=> "FRONTCHASSIS"
		    ],
		    [
		      "part_no"=> "A4A-0026-00",
		      "part_name"=> "BOTTOMPLATE"
		    ],
		    [
		      "part_no"=> "A4A-0026-06",
		      "part_name"=> "BOTTOMPLATE"
		    ],
		    [
		      "part_no"=> "A4A-0039-00",
		      "part_name"=> "BOTTOMPLATE"
		    ],
		    [
		      "part_no"=> "F1C-0088-00",
		      "part_name"=> "LCDCASE"
		    ],
		    [
		      "part_no"=> "J2B-0210-00",
		      "part_name"=> "BRACKET"
		    ],
		    [
		      "part_no"=> "LV11837-003A",
		      "part_name"=> "BOTTOMCHASSIS"
		    ],
		    [
		      "part_no"=> "LV11841-005A",
		      "part_name"=> "TOPCHASSIS"
		    ],
		    [
		      "part_no"=> "LV11877-003A",
		      "part_name"=> "OUTERCHASSIS"
		    ],
		    [
		      "part_no"=> "LV3A271-002A",
		      "part_name"=> "CLBASEASSY"
		    ],
		    [
		      "part_no"=> "LV38950-002A",
		      "part_name"=> "HCCL.BASEASSY"
		    ],
		    [
		      "part_no"=> "LV39936-013A",
		      "part_name"=> "CLAMPARMASSY"
		    ],
		    [
		      "part_no"=> "A2C-0034-0J",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A2C-0034-0M",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A2C-0035-03",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A2C-0035-08",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A6C-0028-0W",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0028-0X",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0084-00",
		      "part_name"=> "PANELASSY"
		    ],
		    [
		      "part_no"=> "B1A-0064-00",
		      "part_name"=> "FRONTGLASS"
		    ],
		    [
		      "part_no"=> "K2F-0009-01",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "A6D-0081-14",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0098-1G",
		      "part_name"=> "PANELASSY"
		    ],
		    [
		      "part_no"=> "B1A-0045-0M",
		      "part_name"=> "FRONTGLASS"
		    ],
		    [
		      "part_no"=> "B1A-0045-0Q",
		      "part_name"=> "FRONTGLASS"
		    ],
		    [
		      "part_no"=> "B1A-0045-1P",
		      "part_name"=> "FRONTGLASS"
		    ],
		    [
		      "part_no"=> "GE10392-001A",
		      "part_name"=> "FRONTPANEL"
		    ],
		    [
		      "part_no"=> "K2E-0008-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "K2F-0041-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "LV3A023-004ANK",
		      "part_name"=> "BUTTONSENSORZ"
		    ],
		    [
		      "part_no"=> "LV3A027-001ANK",
		      "part_name"=> "BUTTONUPDNZ"
		    ],
		    [
		      "part_no"=> "LV3A028-002ANK",
		      "part_name"=> "BUTTONMAPZ"
		    ],
		    [
		      "part_no"=> "A2B-0103-00",
		      "part_name"=> "DRESSINGPANEL"
		    ],
		    [
		      "part_no"=> "A2B-0103-03",
		      "part_name"=> "DRESSINGPANEL"
		    ],
		    [
		      "part_no"=> "A4G-0032-00",
		      "part_name"=> "REARCOVER"
		    ],
		    [
		      "part_no"=> "A4G-0072-00",
		      "part_name"=> "REARCOVER"
		    ],
		    [
		      "part_no"=> "A4G-0072-10",
		      "part_name"=> "REARCOVER"
		    ],
		    [
		      "part_no"=> "A6C-0006-0K",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0044-0B",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0044-0D",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0044-09",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-0T",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-0V",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-0W",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-0X",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-0Z",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0062-15",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-0G",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-0K",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-0Q",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-0V",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0063-0W",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0095-0F",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0095-04",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0095-06",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0017-0D",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "B1A-0014-0C",
		      "part_name"=> "FRONTGLASS"
		    ],
		    [
		      "part_no"=> "B1K-0015-00",
		      "part_name"=> "LIGHTINGBOARD"
		    ],
		    [
		      "part_no"=> "B1K-0016-00",
		      "part_name"=> "LIGHTINGBOARD"
		    ],
		    [
		      "part_no"=> "B1K-0097-00",
		      "part_name"=> "LIGHTINGBOARD"
		    ],
		    [
		      "part_no"=> "B9H-0001-00",
		      "part_name"=> "ESCUTCHEON"
		    ],
		    [
		      "part_no"=> "F0G-0010-00",
		      "part_name"=> "COVER"
		    ],
		    [
		      "part_no"=> "F0G-0011-00",
		      "part_name"=> "COVER"
		    ],
		    [
		      "part_no"=> "GE35856-004A",
		      "part_name"=> "LCDLENS"
		    ],
		    [
		      "part_no"=> "K2K-0112-10",
		      "part_name"=> "KNOBBASE"
		    ],
		    [
		      "part_no"=> "LV11689-001A",
		      "part_name"=> "DISCGUIDE"
		    ],
		    [
		      "part_no"=> "LV11880-003A",
		      "part_name"=> "DISCGUIDE"
		    ],
		    [
		      "part_no"=> "LV3A177-001A",
		      "part_name"=> "WIREHOLDER"
		    ],
		    [
		      "part_no"=> "LV3A179-002A",
		      "part_name"=> "TRIGGERARM"
		    ],
		    [
		      "part_no"=> "LV3A181-002A",
		      "part_name"=> "TRANSFERARM"
		    ],
		    [
		      "part_no"=> "LV3A182-003A",
		      "part_name"=> "SLLOCKARM"
		    ],
		    [
		      "part_no"=> "LV3A183-001A",
		      "part_name"=> "PICKLOCKARM"
		    ],
		    [
		      "part_no"=> "LV3A188-001A",
		      "part_name"=> "TRANSFERGEAR"
		    ],
		    [
		      "part_no"=> "LV3A189-001A",
		      "part_name"=> "LOADGEARH"
		    ],
		    [
		      "part_no"=> "LV3A191-001A",
		      "part_name"=> "JOINTGEAR"
		    ],
		    [
		      "part_no"=> "LV3A194-001A",
		      "part_name"=> "LOADGEARV"
		    ],
		    [
		      "part_no"=> "LV3A196-001A",
		      "part_name"=> "PICKGEAR2"
		    ],
		    [
		      "part_no"=> "LV3A197-001A",
		      "part_name"=> "RACKGEAR"
		    ],
		    [
		      "part_no"=> "LV38957-001A",
		      "part_name"=> "SWSLIDER(R)"
		    ],
		    [
		      "part_no"=> "LV39939-001A",
		      "part_name"=> "WORMGEAR"
		    ],
		    [
		      "part_no"=> "LV44469-001A",
		      "part_name"=> "ROLLER"
		    ],
		    [
		      "part_no"=> "LV45797-002A",
		      "part_name"=> "SLLOCKCAM"
		    ],
		    [
		      "part_no"=> "GE10420-002A",
		      "part_name"=> "CUSHION"
		    ],
		    [
		      "part_no"=> "H1A-0068-00",
		      "part_name"=> "PSFOAMFIXTURE"
		    ],
		    [
		      "part_no"=> "CYUSB230468LI7",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "A2C-0051-02",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A2C-0052-02",
		      "part_name"=> "SUBPANEL"
		    ],
		    [
		      "part_no"=> "A4G-0078-02",
		      "part_name"=> "REARCOVER"
		    ],
		    [
		      "part_no"=> "J7J-0352-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0360-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0205-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0233-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0296-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0301-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0302-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0310-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0320-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0335-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "E2K-0066-00",
		      "part_name"=> "CONDUCTRUBBER"
		    ],
		    [
		      "part_no"=> "A6C-0076-0A",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0076-05",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6C-0076-08",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0083-20",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "A6D-0099-23",
		      "part_name"=> "PANEL"
		    ],
		    [
		      "part_no"=> "K2F-0076-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "K2F-0079-10",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "K2F-0080-00",
		      "part_name"=> "PUSHKNOB"
		    ],
		    [
		      "part_no"=> "K2K-0387-00",
		      "part_name"=> "KNOBASSY"
		    ],
		    [
		      "part_no"=> "LV23006-002A",
		      "part_name"=> "GUIDE2L"
		    ],
		    [
		      "part_no"=> "LV23007-002A",
		      "part_name"=> "GUIDE2R"
		    ],
		    [
		      "part_no"=> "LV39925-001A",
		      "part_name"=> "ROLLERGEAR"
		    ],
		    [
		      "part_no"=> "LV39926-001A",
		      "part_name"=> "DRIVEGEAR1"
		    ],
		    [
		      "part_no"=> "LV39927-001A",
		      "part_name"=> "DRIVEGEAR2"
		    ],
		    [
		      "part_no"=> "LV39928-001A",
		      "part_name"=> "DRIVEGEAR3"
		    ],
		    [
		      "part_no"=> "LV39929-001A",
		      "part_name"=> "DRIVEGEAR4"
		    ],
		    [
		      "part_no"=> "LV39930-003A",
		      "part_name"=> "PICKUPARM"
		    ],
		    [
		      "part_no"=> "QNB0353-001",
		      "part_name"=> "ANTTERMINAL"
		    ],
		    [
		      "part_no"=> "NNZ0256-001X",
		      "part_name"=> "SDCARDCONNE"
		    ],
		    [
		      "part_no"=> "NNZ0268-001X",
		      "part_name"=> "SDCARDCONNE"
		    ],
		    [
		      "part_no"=> "NNZ0303-001X",
		      "part_name"=> "MICROSDCONNE"
		    ],
		    [
		      "part_no"=> "NSW0349-001X",
		      "part_name"=> "DETECTSWITCH"
		    ],
		    [
		      "part_no"=> "NSW0350-001X",
		      "part_name"=> "DETECTSWITCH"
		    ],
		    [
		      "part_no"=> "NSW0351-001X",
		      "part_name"=> "LEVERSWITCH"
		    ],
		    [
		      "part_no"=> "QSW1279-001",
		      "part_name"=> "ROTARYENCODER"
		    ],
		    [
		      "part_no"=> "S7A-0001-009",
		      "part_name"=> "TACTILEPUSHSW"
		    ],
		    [
		      "part_no"=> "S7A-0025-00",
		      "part_name"=> "TACTILEPUSHSW"
		    ],
		    [
		      "part_no"=> "L7H-0052-009",
		      "part_name"=> "SPXO"
		    ],
		    [
		      "part_no"=> "L7J-0005-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0021-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0028-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0052-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0067-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0129-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1135-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1137-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1145-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1168-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1179-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1204-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1208-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1224-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1243-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "L7H-0069-009",
		      "part_name"=> "TCXO"
		    ],
		    [
		      "part_no"=> "L7J-0011-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0059-00",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "L7J-0145-009",
		      "part_name"=> "QUARTZCRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1038-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "NAX1177-001X",
		      "part_name"=> "CRYSTAL"
		    ],
		    [
		      "part_no"=> "CA32AK0J221M8",
		      "part_name"=> "ASECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AR1A471M",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AR1A471M2",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AR1C471M9",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AR1C471M2",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AS0J101M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AS1C101M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AS1C220M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AZ1C101M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AZ1C332M2",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AZ1C471M9",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04ET1C222M1",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04ET1C222M2",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD040AH1CR47M7",
		      "part_name"=> "BPECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD040AJ1C332M",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32BJ1C100M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32BJ1C470M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32BJ1V4R7M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32BM1E470M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32CL0J331M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32CL1C100M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CE32CL1E330M8",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "QEKJ1EM-106Z",
		      "part_name"=> "E.CAPACITOR"
		    ],
		    [
		      "part_no"=> "QERF1AM-107Z",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "E6D-0014-00",
		      "part_name"=> "PINJACK"
		    ],
		    [
		      "part_no"=> "E6D-0015-00",
		      "part_name"=> "PINJACK"
		    ],
		    [
		      "part_no"=> "E6D-0016-00",
		      "part_name"=> "PINJACK"
		    ],
		    [
		      "part_no"=> "GEB10344-001A",
		      "part_name"=> "SWITCHPCB(VALU"
		    ],
		    [
		      "part_no"=> "GEB10358-001D",
		      "part_name"=> "PWBOARD"
		    ],
		    [
		      "part_no"=> "GEB10361-001A",
		      "part_name"=> "SWBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0031-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0111-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0180-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0303-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0321-00",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "EA110AD-2003B",
		      "part_name"=> "WTOBCONNE"
		    ],
		    [
		      "part_no"=> "EA110AD-2007B",
		      "part_name"=> "WTOBCONNE"
		    ],
		    [
		      "part_no"=> "EA110AD-2017B",
		      "part_name"=> "WTOBCONNE"
		    ],
		    [
		      "part_no"=> "EA120AD-2015B",
		      "part_name"=> "WTOBCONNE"
		    ],
		    [
		      "part_no"=> "EA120AD-2031B",
		      "part_name"=> "WTOBCONNE"
		    ],
		    [
		      "part_no"=> "EB760AW-1020A9",
		      "part_name"=> "BTOBCONNE"
		    ],
		    [
		      "part_no"=> "EB760AX-05C0B9",
		      "part_name"=> "BTOBCONNE"
		    ],
		    [
		      "part_no"=> "EB770AX-05C0A9",
		      "part_name"=> "BTOBCONNE"
		    ],
		    [
		      "part_no"=> "EC720AA-0506A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AA-0524A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AB-0570A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AT-0508A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AT-0510A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AT-0516A9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "EC720AT-0516B9",
		      "part_name"=> "FFCFPCCONNE"
		    ],
		    [
		      "part_no"=> "F0K-0014-009",
		      "part_name"=> "SURGEABSORBER"
		    ],
		    [
		      "part_no"=> "QGB1004K1-24",
		      "part_name"=> "BTOBCONNECTO"
		    ],
		    [
		      "part_no"=> "QGB1004K2-20W",
		      "part_name"=> "BTOBCONNE"
		    ],
		    [
		      "part_no"=> "QGF0545F2-13X",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040C1-11",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040C1-24",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040C1-26",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040F1-11",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040F1-24",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "QGF1040F1-26",
		      "part_name"=> "FFC/FPCCONNE"
		    ],
		    [
		      "part_no"=> "CC73GCH1H0R5C9",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CC730BP1H1R8B9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730BP1H101J9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730BP1H471J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CK73FXR1C106K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GBB1C103K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GBB1C683K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GBB1H123K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GXR1C225K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HBB1A683K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HBB1C333K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HBB1E153K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HBB1E223K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HBB1H152K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BS0J105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BU0J106M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BU0J475K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BV1A105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BV1C224K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BW0J226M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730BW1C106K9",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "CK730BY1E106K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730CM1A104K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730CM1C333K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730CM1H222K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730CM1H472K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730DT1C476K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "LB73G0BF-0029",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BF-0039",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BK-0029",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BK-0039",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BK-0069",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BP-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0CA-0019",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0CA-0029",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0CK-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0ED-0049",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0ED-0059",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0FP-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0CC-0039",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0CC-0049",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0CJ-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0CT-0029",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0DZ-0019",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LK73G0AF27NJ9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73H0BXR10J9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73H0BXR15G9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73H0BXR22G9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73H0BX56NJ9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73Z0AK4R7M9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79G0HVR10J9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79H0HU16NJ9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79H0HU18NJ9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79H0HU24NH9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79H0HU7N5G9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79P0BB561K9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0AV100M8",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0DE220M8",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0DE470M8",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0FB220M9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "L3D-0011-009",
		      "part_name"=> "CHOKECOIL"
		    ],
		    [
		      "part_no"=> "L7K-0006-009",
		      "part_name"=> "LINEFILTER"
		    ],
		    [
		      "part_no"=> "L7K-0038-009",
		      "part_name"=> "FILTER"
		    ],
		    [
		      "part_no"=> "L7K-0056-009",
		      "part_name"=> "LCFILTER"
		    ],
		    [
		      "part_no"=> "NCJA1AK-684W-A",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "NDCA1HG-2R7W",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "NQLL8EM-470X",
		      "part_name"=> "INDUCTOR"
		    ],
		    [
		      "part_no"=> "NQLZ021-9N1X",
		      "part_name"=> "INDUCTOR"
		    ],
		    [
		      "part_no"=> "NQR0269-007X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0269-030X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0403-003X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0406-001X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0559-011X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0593-001X",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "NQR0716-001X",
		      "part_name"=> "FERRITECORE"
		    ],
		    [
		      "part_no"=> "NQR0717-001X",
		      "part_name"=> "FERRITECORE"
		    ],
		    [
		      "part_no"=> "NQR0723-001X",
		      "part_name"=> "CHOKECOIL"
		    ],
		    [
		      "part_no"=> "PRF18BE471QS59",
		      "part_name"=> "PTHERMISTOR"
		    ],
		    [
		      "part_no"=> "NJG1143UA28",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJM11100F19",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2535V-ZB9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2561F18",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2584AM9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2746V9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2794RB29",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2794V9",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2819ADL3339",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2819ADL3529",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2831F929",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2855DL1-059",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM2871BF059",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2871BF489",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM2903CRB18",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJM2903CV8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJM2904CV8",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM431SF9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM4565E9",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "NJM4565V-X",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "NJM4580CV8",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJM8065V8",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "NJU7108F39",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJW1240V9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJW1341VC38",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "NJW4190R-A9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "FSMD035-R9",
		      "part_name"=> "PTHERMISTOR"
		    ],
		    [
		      "part_no"=> "FZA10BF-R509",
		      "part_name"=> "FUSE(CC)"
		    ],
		    [
		      "part_no"=> "FZA10BF-1R09",
		      "part_name"=> "FUSE(CC)"
		    ],
		    [
		      "part_no"=> "FZA10BF-4R09",
		      "part_name"=> "FUSE(CC)"
		    ],
		    [
		      "part_no"=> "FZB10BT-100",
		      "part_name"=> "BLADEFUSE"
		    ],
		    [
		      "part_no"=> "BA00DD0WHFP8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BA2904FVM9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BA2904WFV9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BA6956AN",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "BD00C0AWFP9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD00HA5WEFJ9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD00IA5WEFJ9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD00IC0EEFJ-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD00KA5WFP9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD12KA5FP9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD15KA5WFP9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD2242G-G9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD33IC0WEFJ9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD33KA5WFP9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD37067FV-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD37069FV-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD450M2EFJ-C9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD8152FVM9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BD82032FVJ-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD8205EFV-M9",
		      "part_name"=> "BIPOLARIC"
		    ],
		    [
		      "part_no"=> "BD8255MUV-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD8266EFV-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BD9876AEFJ9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BR24T02FJ-W9",
		      "part_name"=> "ROMIC"
		    ],
		    [
		      "part_no"=> "BR24T32FVT-W9",
		      "part_name"=> "ROMIC"
		    ],
		    [
		      "part_no"=> "BU1CTD3WG8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU17101AKV-M9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU18TD3WG8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU33TD3WG8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU4228F9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BU4228FVE-W",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "BU7252FVM9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU97520AKV-M9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "BU97530KVT-M9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "BU97550KV-M9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "DAN202U9",
		      "part_name"=> "DIODEARRAY"
		    ],
		    [
		      "part_no"=> "DAP202U9",
		      "part_name"=> "DIODEARRAY"
		    ],
		    [
		      "part_no"=> "IMX99",
		      "part_name"=> "DUALTRANSISTOR"
		    ],
		    [
		      "part_no"=> "LSAR523EBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LSAR523UBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LSCR523EBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LSCR523UBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA014EEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA014TEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA014TUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA014YEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA014YUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA024EEBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA043ZEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTA044EEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC014EEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC014YEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC014YUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC024EEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC024EUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC043EUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC043TEBFS89",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC043ZEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC044EEBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "LTC044EUBFS89",
		      "part_name"=> "DIGITRANSISTOR"
		    ],
		    [
		      "part_no"=> "ML86101ATBB7F7",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "ML86250LAZ07F7",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "RB051L-409",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB056L-409",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB080L-309",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB085BM-409",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB160M-309",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB160M-609",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB161M-20-X",
		      "part_name"=> "SBDIODE"
		    ],
		    [
		      "part_no"=> "RB162MM-609",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB501VM-409",
		      "part_name"=> "SCHOTTKYDIODE"
		    ],
		    [
		      "part_no"=> "RB521SM-309",
		      "part_name"=> "DIODE"
		    ],
		    [
		      "part_no"=> "RE1C002ZP9",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "RK73P0CMR18J9",
		      "part_name"=> "MGRESISTOR"
		    ],
		    [
		      "part_no"=> "RK73P0CMR22J9",
		      "part_name"=> "MGRESISTOR"
		    ],
		    [
		      "part_no"=> "RK73P0CMR27J9",
		      "part_name"=> "MGRESISTOR"
		    ],
		    [
		      "part_no"=> "RN731V9",
		      "part_name"=> "DIODE"
		    ],
		    [
		      "part_no"=> "RSB6.8SM9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "RSQ030P039",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "RTQ035N039",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "RTR020P029",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "RT1E040RP9",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "RZ73F0AK33LJ9",
		      "part_name"=> "RESISTOR"
		    ],
		    [
		      "part_no"=> "RZ73F0AK47LJ9",
		      "part_name"=> "RESISTOR"
		    ],
		    [
		      "part_no"=> "RZ73F0AK62LJ9",
		      "part_name"=> "RESISTOR"
		    ],
		    [
		      "part_no"=> "RZ73Z0AX180J9",
		      "part_name"=> "RESISTOR"
		    ],
		    [
		      "part_no"=> "SML-D12D8W9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "SML-D12P8WT9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "SML-D12V8WSPQ9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "SML-D12V8WT9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "SML-311WTJK9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "SMLP36RGB2W3J9",
		      "part_name"=> "LED"
		    ],
		    [
		      "part_no"=> "UDZV13B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV18B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV5.1B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV5.6B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV6.2B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV6.8B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV7.5B9",
		      "part_name"=> "ZENERDIODE"
		    ],
		    [
		      "part_no"=> "UDZV7.5B-X",
		      "part_name"=> "ZDIODE"
		    ],
		    [
		      "part_no"=> "UMX1N9",
		      "part_name"=> "DUALTRANSISTOR"
		    ],
		    [
		      "part_no"=> "1SS355VM9",
		      "part_name"=> "DIODE"
		    ],
		    [
		      "part_no"=> "2SAR512P8",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SAR572DG9",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SA20189",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SB1197K/QR/9",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SB16899",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SB1709MG9",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SC4617EB/QR/9",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SC55859",
		      "part_name"=> "TRANSISTOR"
		    ],
		    [
		      "part_no"=> "2SK30199",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "CB73QAD1C106M9",
		      "part_name"=> "FILMCAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AV1C100M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AV1C101M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AV1C470M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AV1H4R7M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04AV1V4R7M7",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CD04BN1C221M9",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "QEZ0982-476Z",
		      "part_name"=> "ECAPACITOR"
		    ],
		    [
		      "part_no"=> "CC73HCH1H010C9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC73HCH1H020C9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H030C9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H040C9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H060D9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H102J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H120J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H221J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H331J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC73HCH1H681J9",
		      "part_name"=> "CCAPACITOR(1)"
		    ],
		    [
		      "part_no"=> "CC730AS1H060D9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730AS1H102J9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730AS1H120J9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730AS1H150J9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CC730AS1H681J9",
		      "part_name"=> "CCAPACITOR1"
		    ],
		    [
		      "part_no"=> "CK73EXR0J476M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73EXR1C226M9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73FBB0J106K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73FBB1E105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73FBB1H104K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73FXR0J226M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GBB1C105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GBB1H104K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GXR0J106K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73GXR0J106M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GXR0J225K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73GXR1A106K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73GXR1A225K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73GXR1A475K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73GXR1C105K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HBB0J224K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HBB1C104K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HBB1H103K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK73HXR0J224K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1A105K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1A224K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1A334K9",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "CK73HXR1A683K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1A823K9",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "CK73HXR1C103K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1C104K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1C105K9",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "CK73HXR1C224K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1C333K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1E153K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1E223K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1H152K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1H222K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1H332K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK73HXR1H472K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730AU0J105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AU1H682K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730AV1A105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AV1C105K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AV1C224K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AW0J475K9",
		      "part_name"=> "CCAPACITOR2"
		    ],
		    [
		      "part_no"=> "CK730AX0J106K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AY0J226M9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "CK730AY1C106K9",
		      "part_name"=> "CCAPACITOR(2)"
		    ],
		    [
		      "part_no"=> "LB73G0BA-0059",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73G0BD-0069",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73G0BE-0029",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73H0AV-0029",
		      "part_name"=> "CHIPFERRITE"
		    ],
		    [
		      "part_no"=> "LB73H0AY-0049",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LB73H0BG-0039",
		      "part_name"=> "FERRITEBEADS"
		    ],
		    [
		      "part_no"=> "LK73G0AQR22K9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73G0AQ1R0K9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73G0AQ2R7K9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73G0ASR22J9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73G0AS10NJ9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73G0AS5N6S9",
		      "part_name"=> "MLINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73H0AM27NJ9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LK73Z0CA4R7M9",
		      "part_name"=> "M.CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AC100K9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD1R0M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD100K9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD100M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD220M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD4R7M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AD470M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AER15J9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AER47J9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AER68J9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AE1R8J9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR73Z0AE470J9",
		      "part_name"=> "CHIPINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0AG100M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0AH100M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0AH220M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "LR79Z0AK220M9",
		      "part_name"=> "WWINDUCTOR"
		    ],
		    [
		      "part_no"=> "NCB10JK-226X-R",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "NCB21AK-475X",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "NCJ20JK-106X-R",
		      "part_name"=> "CCAPACITOR"
		    ],
		    [
		      "part_no"=> "AS431AN-G19",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "JCV8021",
		      "part_name"=> "IC(DIGITAL)"
		    ],
		    [
		      "part_no"=> "JCV8022",
		      "part_name"=> "IC(DIGITAL)"
		    ],
		    [
		      "part_no"=> "SSM3K15AMFVF9",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "TB2931HQ",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "TB2996HQ",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "TC4052BFT9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7PG17FU-F8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SET08FU-J-X",
		      "part_name"=> "IC(DIGITAL)"
		    ],
		    [
		      "part_no"=> "TC7SET32FU-X",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "TC7SH00FUJF9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH08FU-X",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "TC7SH08FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH08FUJF9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH17FUF9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH17FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SH32FUJC9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7SZ125FUF9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7USB42FT9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7WBL3305CFK8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7WH125FKJC8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC7WZ34FUJC8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "TC74HCT4053FT9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "3SK291F9",
		      "part_name"=> "FET"
		    ],
		    [
		      "part_no"=> "J7J-0318-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0319-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0320-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7J-0321-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0206-10",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0207-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "J7K-0343-20",
		      "part_name"=> "PRINTEDBOARD"
		    ],
		    [
		      "part_no"=> "QLD0735-001",
		      "part_name"=> "LCDMODULE"
		    ],
		    [
		      "part_no"=> "L7K-0030-009",
		      "part_name"=> "FILTER"
		    ],
		    [
		      "part_no"=> "XC6120N282N-G8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6201P502P-G9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6209B502P-G9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6213B122N-G8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6213B152N-G8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6213B182N-G8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6213B332N-G8",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6216B852P-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "XC6220B121P-G9",
		      "part_name"=> "IC"
		    ],
		    [
		      "part_no"=> "XC6223B121P-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "XC6223B331P-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "XC6223D331P-G9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6223H251M-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "XC6503D331P-G9",
		      "part_name"=> "MOSIC"
		    ],
		    [
		      "part_no"=> "XC6602B181P-G9",
		      "part_name"=> "ANALOGIC"
		    ],
		    [
		      "part_no"=> "L3B-0001-00",
		      "part_name"=> "FM-RFCOIL"
		    ],
		    [
		      "part_no"=> "L3B-0004-00",
		      "part_name"=> "FM-RFCOIL"
		    ],
		    [
		      "part_no"=> "L3B-0005-009",
		      "part_name"=> "FM-RFCOIL"
		    ],
		    [
		      "part_no"=> "QQR1872-001",
		      "part_name"=> "RFCOIL"
		    ],
		    [
		      "part_no"=> "B0B-0006-01",
		      "part_name"=> "DRESSINGPLATE"
		    ],
		    [
		      "part_no"=> "B1B-0009-00",
		      "part_name"=> "OPTI.DIFFUSER"
		    ],
		    [
		      "part_no"=> "B1B-0010-00",
		      "part_name"=> "OPTI.DIFFUSER"
		    ],
		    [
		      "part_no"=> "B1B-0049-00",
		      "part_name"=> "OPTI.DIFFUSER"
		    ],
		    [
		      "part_no"=> "B1B-0050-00",
		      "part_name"=> "REF.SHEET"
		    ],
		    [
		      "part_no"=> "B1B-0085-00",
		      "part_name"=> "OPTI.DIFFUSER"
		    ],
		    [
		      "part_no"=> "B1B-0090-00",
		      "part_name"=> "REF.SHEET"
		    ],
		    [
		      "part_no"=> "B1B-0114-00",
		      "part_name"=> "OPTI.DIFFUSER"
		    ],
		    [
		      "part_no"=> "B4A-0066-04",
		      "part_name"=> "STICKER"
		    ],
		    [
		      "part_no"=> "B4B-0051-00",
		      "part_name"=> "CAUTIONSTICKER"
		    ],
		    [
		      "part_no"=> "F0K-0052-01",
		      "part_name"=> "SHEET"
		    ],
		    [
		      "part_no"=> "F2A-0016-00",
		      "part_name"=> "INS.SHEET"
		    ],
		    [
		      "part_no"=> "GE34844-002A",
		      "part_name"=> "INSULATOR"
		    ],
		    [
		      "part_no"=> "GE35119-002A",
		      "part_name"=> "INSULATOR"
		    ],
		    [
		      "part_no"=> "GE35861-002A",
		      "part_name"=> "REFLECTIONSHT"
		    ],
		    [
		      "part_no"=> "GE35993-001A",
		      "part_name"=> "NAMEPLATE"
		    ],
		    [
		      "part_no"=> "GE40631-001A",
		      "part_name"=> "REFLECTIONSHT"
		    ],
		    [
		      "part_no"=> "GE40672-001A",
		      "part_name"=> "REFLECTIONSHT"
		    ],
		    [
		      "part_no"=> "G1B-0071-02",
		      "part_name"=> "CUSHION"
		    ],
		    [
		      "part_no"=> "G1B-0071-05",
		      "part_name"=> "CUSHION"
		    ],
		    [
		      "part_no"=> "LV3A295-001A",
		      "part_name"=> "BOTTOMSHEET"
		    ],
		    [
		      "part_no"=> "LV3A786-001A",
		      "part_name"=> "STICKERLABEL"
		    ],
		    [
		      "part_no"=> "LV39933-001A",
		      "part_name"=> "BOTTOMSHEET"
		    ],
		    [
		      "part_no"=> "LV45719-001A",
		      "part_name"=> "PUFPCSHEET"
		    ],
		    [
		      "part_no"=> "LV45927-001A",
		      "part_name"=> "SPACER"
		    ],
		    [
		      "part_no"=> "LV45939-001A",
		      "part_name"=> "GPSBRACKET"
		    ],
		    [
		      "part_no"=> "LV45991-001A",
		      "part_name"=> "SHEET"
		    ],
		    [
		      "part_no"=> "NSW0326-001X",
		      "part_name"=> "TACTSWITCH"
		    ],
		    [
		      "part_no"=> "E3A-0218-00",
		      "part_name"=> "DCCORDASSY"
		    ],
		    [
		      "part_no"=> "E3A-0236-00",
		      "part_name"=> "CORDWITHPLUG"
		    ],
		    [
		      "part_no"=> "E3A-0274-00",
		      "part_name"=> "CORDW.PINJACK"
		    ],
		    [
		      "part_no"=> "E3A-0346-00",
		      "part_name"=> "CORDWITHPLUG"
		    ],
		    [
		      "part_no"=> "E3A-0362-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0364-00",
		      "part_name"=> "USBCORD"
		    ],
		    [
		      "part_no"=> "E3A-0365-00",
		      "part_name"=> "USBCORD"
		    ],
		    [
		      "part_no"=> "E3A-0372-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0373-00",
		      "part_name"=> "CORDW.CON."
		    ],
		    [
		      "part_no"=> "E3A-0380-00",
		      "part_name"=> "DCCORD"
		    ]
		];

		foreach ($pck31s as $key => $value) {
			$suppliers_id = $supplier[ ceil( rand(0,486 ) )]->id;
			$model = str_random(30);
			$first_value = ceil(rand(0, 99999));
			$total_delivery = $first_value;
			$total_qty = 0;

			$part = new Part;
			$part->no = $value['part_no'];
			$part->name = $value['part_name'];
			$part->suppliers_id = $suppliers_id;
			$part->model = $model;
			$part->first_value = $first_value;
			$part->total_delivery = $total_delivery;
			$part->total_qty = $total_qty;

			$part->save();

		}
		
    }
}
