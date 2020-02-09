<?php

namespace App;

class Customer extends BaseModel {

    protected $table = 'tbl_transactional_customers';
    protected $primaryKey = 'id';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'business_name', 'contact', 'telephone', 'email', 'street', 'internal_number',
        'external_number', 'settlement', 'city', 'county', 'state', 'postal_code', 'country', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'system_customer', 'remember_token', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
    ];
    
}
