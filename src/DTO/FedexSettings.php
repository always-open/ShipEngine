<?php

namespace AlwaysOpen\ShipEngine\DTO;

use AlwaysOpen\ShipEngine\DTO\Validators\InArray;
use Spatie\DataTransferObject\DataTransferObject;

class FedexSettings extends DataTransferObject
{
    public string $nickname;
    #[InArray(['none', 'regular_pickup', 'request_courier', 'drop_box', 'business_service_center', 'station'])]
    public string $pickup_type;
    #[InArray(['none', 'allentown_pa', 'atlanta_ga', 'baltimore_md', 'charlotte_nc', 'chino_ca', 'dallas_tx', 'denver_co', 'detroit_mi', 'edison_nj', 'grove_city_oh', 'groveport_oh', 'houston_tx', 'indianapolis_in', 'kansas_city_ks', 'los_angeles_ca', 'martinsburg_wv', 'memphis_tn', 'minneapolis_mn', 'new_berlin_wi', 'northborough_ma', 'orlando_fl', 'phoneix_az', 'pittsburgh_pa', 'reno_nv', 'sacramento_ca', 'salt_lake_city_ut', 'seattle_wa', 'st_louis_mo', 'windsor_ct', 'newark_ny', 'south_brunswick_nj', 'scranton_pa', 'wheeling_il'])]
    public string $smart_post_hub;
    #[InArray(['none', 'return_service_requested', 'forwarding_service_requested', 'address_service_requested', 'change_service_requested', 'leave_if_no_response'])]
    public string $smart_post_endorsement;
    public bool $is_primary_account;
    public string $signature_image;
    public string $letterhead_image;
}
