package com.peachtree.wpbapp.Core;

import android.content.Context;
import android.location.Location;
import android.util.Log;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.JsonHttpResponseHandler;
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
 */

public class Events  {

    private Context CURRENT_CONTEXT;

    private Networking API_HELPER;

    private String MULTIPLE_EVENTS_API_URL;
    private String SINGLE_EVENT_API_URL;

    public Events(Context ctx) {
        CURRENT_CONTEXT = ctx;

        API_HELPER = new Networking(ctx);

        MULTIPLE_EVENTS_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.ALL_EVENTS);
        SINGLE_EVENT_API_URL = API_HELPER.GetApiBaseUrl() + CURRENT_CONTEXT.getString(R.string.VIEW_EVENT);
    }

    public Event GetEventById(int id) {
        return new Event();
    }

    public void GetEventById(int id, AsyncHttpResponseHandler handler) {

    }

    public void GetAllEvents(AsyncHttpResponseHandler handler) {
        Networking.Get(MULTIPLE_EVENTS_API_URL, null, handler);
    }

    public ArrayList<Event> GetEventsForDate(Date date) {
        return new ArrayList<Event>();
    }

    public void GetEventsForDate(Date date, AsyncHttpResponseHandler handler) {

    }

    public ArrayList<Event> GetEventsForLocation(Location loc) {
        return new ArrayList<Event>();
    }

    public void GetEventsForLocation(Location loc, AsyncHttpResponseHandler handler) {

    }

}
