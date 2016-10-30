package com.peachtree.wpbapp.Core.impl;

import android.util.Log;

/**
 * Created by chrisetheridge on 10/30/16.
 */

public class Generic {

    private String API_URL;

    public Generic(String api_url) {
        String[] parts = api_url.split("/");

        if(parts[1] != "api") {
            Log.w("API", "API URL provided does not contain \"API\", did you spell it correctly? api_url = " + api_url);
        }

        API_URL = api_url;
    }


    public static class ErrorCodes {
        public static final int RSVP__INSUFFICIENT_PARAMETERS_SUPPLIED = 443;
        public static final int RSVP__ATTENDING_ILLEGAL_OPTION = 444;
        public static final int RSVP__UNKNWON_DB_ERROR = 445;
        public static final int GET_EVENTS__UNKNOWN_DB_ERROR = 222;
        public static final int GET_EVENTS__NO_ID_SPECIFIED_ERROR = 223;
        public static final int GET_CLINICS__UNKNOWN_DB_ERROR = 332;
        public static final int GET_CLINICS__NO_CLINIC_ID_SPECIFIED = 333;
    }


}
