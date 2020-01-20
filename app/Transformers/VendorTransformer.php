<?php
/**
 * Invoice Ninja (https://invoiceninja.com)
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2020. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://opensource.org/licenses/AAL
 */

namespace App\Transformers;

use App\Models\Activity;
use App\Models\Vendor;
use App\Models\VendorContact;
use App\Models\VendorGatewayToken;
use App\Transformers\ActivityTransformer;
use App\Transformers\VendorContactTransformer;
use App\Transformers\VendorGatewayTokenTransformer;
use App\Utils\Traits\MakesHash;

/**
 * class VendorTransformer
 */
class VendorTransformer extends EntityTransformer
{
    use MakesHash;

    protected $defaultIncludes = [
        'contacts',
    ];

    /**
     * @var array
     */
    protected $availableIncludes = [
        'activities',
    ];


    /**
     * @param Vendor $vendor
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeActivities(Vendor $vendor)
    {
        $transformer = new ActivityTransformer($this->serializer);

        return $this->includeCollection($vendor->activities, $transformer, Activity::class);
    }

    /**
     * @param Vendor $vendor
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeContacts(Vendor $vendor)
    {
        $transformer = new VendorContactTransformer($this->serializer);

        return $this->includeCollection($vendor->contacts, $transformer, VendorContact::class);
    }

    /**
     * @param Vendor $vendor
     *
     * @return array
     */
    public function transform(Vendor $vendor)
    {
        return [
            'id' => $this->encodePrimaryKey($vendor->id),
            'user_id' => $this->encodePrimaryKey($vendor->user_id),
            'assigned_user_id' => $this->encodePrimaryKey($vendor->assigned_user_id),
            'name' => $vendor->name ?: '',
            'website' => $vendor->website ?: '',
            'private_notes' => $vendor->private_notes ?: '',
            'last_login' => (int)$vendor->last_login,
            'address1' => $vendor->address1 ?: '',
            'address2' => $vendor->address2 ?: '',
            'phone' => $vendor->phone ?: '',
            'city' => $vendor->city ?: '',
            'state' => $vendor->state ?: '',
            'postal_code' => $vendor->postal_code ?: '',
            'country_id' => (string)$vendor->country_id ?: '',
            'custom_value1' => $vendor->custom_value1 ?: '',
            'custom_value2' => $vendor->custom_value2 ?: '',
            'custom_value3' => $vendor->custom_value3 ?: '',
            'custom_value4' => $vendor->custom_value4 ?: '',
            'is_deleted' => (bool) $vendor->is_deleted,
            'vat_number' => $vendor->vat_number ?: '',
            'id_number' => $vendor->id_number ?: '',
            'updated_at' => $vendor->updated_at,
            'archived_at' => $vendor->deleted_at,
        ];
    }
}