<?php

/**
 * 
 * Umbauen von Cockpit Mail Vorlagen auf MGL_1_78
 *
 * WIP
 *
 * @package
 * @author yaz
 */
return new class extends migration {
    public const array DEPENDENCIES = [];
    public const bool MANUAL_APPROVAL_REQUIRED = false;

    /**
     * Run the migration
     */
    public function up(): void
    {
        // Datenbank von EV_NEWSBLOECKE auf MGL_1_78 ändern für Mail Vorlagen
        $this->updateByGuid(
            'EV_TABDEF',
            [
                'AEND_DATUM' => '2026-05-22',
                'AEND_USER' => 'yaz',
                'DBASE' => 'MGL_1_78'
            ],
            '6335601d-f944-11e8-8a41-0025643aa10f'
        );

        // Alte EV_NEWSBLOECKE spalten löschen
        $ev_spadef_delete_guids = [
            '508a15b7-cfa1-11ec-a7ba-8c164553f637',
            '508ebd82-cfa1-11ec-a7ba-8c164553f637',
            '47d20037-fd88-11ea-8335-b496915c5999',
            '47c265b6-fd88-11ea-8335-b496915c5999',
            '517a18aa-f952-11e8-8a41-0025643aa10f',
            'c4ceff75-f944-11e8-8a41-0025643aa10f'
        ];
        foreach ($ev_spadef_delete_guids as $to_delete) {
            $this->updateByGuid(
                'EV_SPADEF',
                [
                    'AEND_DATUM' => '2026-05-22',
                    'AEND_USER' => 'yaz',
                    'DELETED' => '1'
                ],
                $to_delete
            );
        }

        // Neue MGL_1_78 spalten hinzufügen
        // Eintrag -> DBFeld -> Wert
        $ev_spadef_unique_data = [
            [
                'VARNAME' => 'BETREFF',
                'GUID' => '4a27227e-55d1-11f1-b949-bc2411bb7bcb',
                'SPAPOS' => '1'
            ],
            [
                'VARNAME' => 'ANL_USER',
                'GUID' => '4a31bd56-55d1-11f1-b949-bc2411bb7bcb',
                'SPAPOS' => '2'
            ],
            [
                'VARNAME' => 'AEND_DATUM',
                'GUID' => '4a3620f6-55d1-11f1-b949-bc2411bb7bcb',
                'SPAPOS' => '3'
            ]
        ];

        foreach ($ev_spadef_unique_data as $data) {
            $this->insertIfNotExists(
                'EV_SPADEF',
                [
                    'DELETED' => '0',
                    'SPAPOS' => $data['SPAPOS'],
                    'SPALEN' => null,
                    'VARNAME' => $data['VARNAME'],
                    'DBASE' => 'MGL_1_78',
                    'FIELD_TYPE' => null,
                    'FIELD_LEN' => 0,
                    'FIELD_DEC' => 0,
                    'FIELD_TAU' => 1,
                    'SPAHEADER' => null,
                    'AEND_DATUM' => '2026-05-22',
                    'AEND_USER' => 'yaz',
                    'SORTFIELD' => '',
                    'ALIGN' => 'L',
                    'STAND' => 0,
                    'FREIGABE' => null,
                    'VERFALL' => null,
                    'REF_LFDNR' => 0,
                    'ANL_USER' => 'yaz',
                    'ANL_DATUM' => '2026-05-22',
                    'GUID' => $data['GUID'],
                    'ZEV_TABDEF' => '6335601d-f944-11e8-8a41-0025643aa10f',
                    'SEARCHABLE' => 1,
                    'SORTABLE' => 1,
                    'SWITCHCELL' => 0,
                    'SWITCH_ON_LABEL' => null,
                    'SWITCH_OFF_LABEL' => null,
                    'SWITCH_ON_VALUE' => null,
                    'SWITCH_SKRIPT' => null,
                    'SWITCH_ID' => null,
                    'SWITCH_NAME' => null,
                    'ICONCELL' => 0,
                    'ICON_VALUE' => null,
                    'SCHICHT' => 'Custom',
                    'GROUP' => 0,
                    'HIDDEN' => 0,
                    'DEFAULT' => 1,
                    'SHOW_IF' => ''
                ],
                ['GUID']
            );
        }
    }
};
```
