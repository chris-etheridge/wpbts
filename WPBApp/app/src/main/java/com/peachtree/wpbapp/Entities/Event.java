package com.peachtree.wpbapp.Entities;

import java.util.Date;

/**
 * Created by chrisetheridge on 8/25/16.
 */
public class Event {

    private enum EventType {

    }

    private int id;
    private Date date;
    private String address;
    private String title;
    private boolean active;
    private String description;
    private EventType type;
    private int urgency;

    public int getId() {
        return this.id;
    }

    public Date getDate() {
        return this.date;
    }

    public String getAddress() {
        return this.address;
    }

    public String getTitle() {
        return this.title;
    }

    public boolean isActive() {
        return this.active;
    }

    public String getDescription() {
        return this.description;
    }

    public EventType getType() {
        return this.type;
    }

    public int getUrgency() {
        return this.urgency;
    }

}
