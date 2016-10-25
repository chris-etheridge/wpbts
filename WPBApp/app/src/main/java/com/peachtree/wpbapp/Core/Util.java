package com.peachtree.wpbapp.core;

import android.graphics.drawable.Drawable;

import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.Date;

/**
 * General utilities.
 */
public class Util {

	public static String getDateString(Date date){
		DateFormat format = new SimpleDateFormat("dd MMMM yyyy");

		return format.format(date);
	}
}
