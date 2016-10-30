package com.peachtree.wpbapp.Core;

import android.location.Location;

import com.loopj.android.http.AsyncHttpResponseHandler;
import com.peachtree.wpbapp.Core.impl.Core;
import com.peachtree.wpbapp.Entities.Event;

import java.util.ArrayList;
import java.util.Date;

/**
 * Created by chrisetheridge on 10/30/16.
 */

public class Events  {

    private static String MULTIPLE_EVENTS_API_URL = "/api/events/view_events.php";
    private static String SINGLE_EVENT_API_URL = "/api/events/view_event.php";

    public Events() {

    }

    public Event GetEventById(int id) {
        return new Event();
    }

    public void GetEventById(int id, AsyncHttpResponseHandler handler) {

    }

    public ArrayList<Event> GetAllEvents() {
        return new ArrayList<Event>();
    }

    public void GetAllEvents(AsyncHttpResponseHandler handler) {

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
