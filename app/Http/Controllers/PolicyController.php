<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PropertyController extends Controller
{
    public function Index()
    {
        $policy = "maihommanager is the management tool that helps the 
        landlord/real estate agent or property owners/renters to manage
         the home, collect the rent, remind/enforce the occupants to take
          part in their house hold duties/policies, provide an effective 
          platform that enhances friendly home, communications amongst 
          households and the landlord and home affairs etc. Apart from just
           turning up to collect the rent, it is very hard to manage overall
            aspact of house/property for rents by the land lord. So many 
            Landlords who has people in their house for rents face challenges
             trying to make sure their property is well managed and looked 
             after. Arguments between the tenants, late or untimely rent 
             payment, lack of communication between the landlord and tenants
              etc. are some of those areas challenging for the landlord. 
              Especially for those shared house (Renting rooms) it is even 
              more bizarre. Hence maihommanager is the management tool that 
              helps the landlord/real estate agent or property owners/renters
               to manage the home, collect the rent, remind/enforce the 
               occupants to take part in their house hold duties/policies,
                provide an effective platform that enhances friendly home, 
                communications amongst households and the landlord and home 
                affairs etc. The system is a customised solution property 
                manager app- designed and developed based on research and 
                personal experience living in number of years in shared 
                accommodations. Living in a shared house/accomodation is 
                sometimes worse given the people with a different ways of 
                living and doing things. App is designed to work on those 
                areas and help the landlord manage its property well and 
                efficiently. The app takes over the landlords management tasks
                 and allows landlord to save time, effort, money and increase 
                 its profitability.";
        return response()->json(["status" => true, "data" => [$policy]]);
    }
}
