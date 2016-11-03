package com.peachtree.wpbapp.Core;

import android.content.Context;
import android.location.Location;
import android.util.Log;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.loopj.android.http.RequestParams;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;

import cz.msebera.android.httpclient.Header;


/**
 * Created by chrisetheridge on 10/30/16.
 * Events API helper
 */

public class Events  {

    // current calling context
    private Context CURRENT_CONTEXT;

    // networking API helper
    private Networking API_HELPER;

    // URL endpoint for all events
    private String ALL_EVENTS_API_URL;
    private String RSVP_EVENT_API_URL;

    // creates a new Events helper
    public Events(Context ctx) {
        CURRENT_CONTEXT = ctx;

        API_HELPER = new Networking(ctx);

        ALL_EVENTS_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.ALL_EVENTS);
        RSVP_EVENT_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.RSVP_EVENT);
    }

    // GETs all events, and calls handler
    public void GetAllEvents(AsyncHttpResponseHandler handler) {
        Networking.Get(ALL_EVENTS_API_URL, null, handler);
    }

    public void RSVPToEvent(String event_id, String user_id, String attending, AsyncHttpResponseHandler handler) {
        JSONObject params = new JSONObject();

        try {
            params.put("eventid", event_id);
            params.put("userid", user_id);
            params.put("attending", attending);
        } catch (JSONException e) {
            e.printStackTrace();
        }

        Networking.Post(RSVP_EVENT_API_URL, params, handler);
    }
}
