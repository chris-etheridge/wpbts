package com.peachtree.wpbapp.Core;

import android.location.Location;
import android.util.Log;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Entities.Event;

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

    private static Networking API_HELPER;

    private String MULTIPLE_EVENTS_API_URL = API_HELPER.GetApiBaseUrl() +  "/api/events/view_events.php";
    private String SINGLE_EVENT_API_URL = API_HELPER.GetApiBaseUrl() +  "/api/events/view_event.php";

    public Event GetEventById(int id) {
        return new Event();
    }

    public void GetEventById(int id, AsyncHttpResponseHandler handler) {

    }

    public void GetAllEvents(AsyncHttpResponseHandler handler) {
        API_HELPER.Get(MULTIPLE_EVENTS_API_URL, null, handler);
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
