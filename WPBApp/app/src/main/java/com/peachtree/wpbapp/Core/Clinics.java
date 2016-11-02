package com.peachtree.wpbapp.Core;

import android.content.Context;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.peachtree.wpbapp.R;

/**
 * Created by chrisetheridge on 10/30/16.
 */

public class Clinics {

    private Context CURRENT_CONTEXT;

    private Networking API_HELPER;

    private String MULTIPLE_CLINICS_API_URL;
    private String SINGLE_CLINIC_API_URL;

    public Clinics(Context ctx) {
        CURRENT_CONTEXT = ctx;

        API_HELPER = new Networking(ctx);

        MULTIPLE_CLINICS_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.ALL_CLINICS);
        SINGLE_CLINIC_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.VIEW_CLINIC);
    }

    public void GetAllClinics(AsyncHttpResponseHandler handler) {
        Networking.Get(MULTIPLE_CLINICS_API_URL, null, handler);
    }

}
