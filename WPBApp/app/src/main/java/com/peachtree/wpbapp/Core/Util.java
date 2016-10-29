package com.peachtree.wpbapp.core;

import com.peachtree.wpbapp.entities.Event;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;

/**
 * General utilities.
 */
public class Util {

	public static String getDateString(Date date){
		DateFormat format = new SimpleDateFormat("dd MMMM yyyy");

		return format.format(date);
	}

	public ArrayList<Event> getEvents(){
		ArrayList<Event> events = null;

		return events;
	}
}
