package com.peachtree.wpbapp.Core;

import android.content.Context;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.peachtree.wpbapp.R;

/**
 * Created by chrisetheridge on 10/30/16.
 * Clinics API helper
 */

public class Clinics {

    // current calling context
    private Context CURRENT_CONTEXT;

    // networking helper
    private Networking API_HELPER;

    // API url for multiple clinics
    private String MULTIPLE_CLINICS_API_URL;

    // creates a new Clinics helper
    public Clinics(Context ctx) {
        CURRENT_CONTEXT = ctx;

        API_HELPER = new Networking(ctx);

        MULTIPLE_CLINICS_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.ALL_CLINICS);
    }

    // GETs all clinics, and calls the handler
    public void GetAllClinics(AsyncHttpResponseHandler handler) {
        Networking.Get(MULTIPLE_CLINICS_API_URL, null, handler);
    }

}
