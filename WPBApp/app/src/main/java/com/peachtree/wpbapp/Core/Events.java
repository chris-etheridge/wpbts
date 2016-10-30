package com.peachtree.wpbapp.Core;

import android.location.Location;

import com.peachtree.wpbapp.Core.impl.Generic;
import com.peachtree.wpbapp.Entities.Event;

import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.Date;

/**
 * Created by chrisetheridge on 10/30/16.
 */

public class Events extends Generic {

    public Events(String api_url) {
        super(api_url);
    }

    public Event GetEventById(int id) {
        return new Event();
    }

    public ArrayList<Event> GetAllEvents() {
        return new ArrayList<Event>();
    }

    public ArrayList<Event> GetEventsForDate(Date date) {
        return new ArrayList<Event>();
    }

    public ArrayList<Event> GetEventsForLocation(Location loc) {
        return new ArrayList<Event>();
    }

}
