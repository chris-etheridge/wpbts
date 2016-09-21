package com.peachtree.wpbapp.core;

import android.content.Context;
import android.content.Intent;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.activity.*;

/**
 * General utilities.
 */
public class Util {

	public static Intent getNavIntent(int id, Context ctx)
	{
		Intent result = null;

		switch (id){
			case R.id.nav_event_list:
				if(ctx.getClass() != Event_List_Activity.class){
					result = new Intent(ctx, Event_List_Activity.class);
				}
				break;
			case R.id.nav_event_calender:
				if(ctx.getClass() != Event_Calendar_Activity.class){
					result = new Intent(ctx, Event_Calendar_Activity.class);
				}
				break;
			case R.id.nav_event_map:
				if(ctx.getClass() != Event_Map_Activity.class){
					result = new Intent(ctx, Event_Map_Activity.class);
				}
				break;
			case R.id.nav_clinics:
				if(ctx.getClass() != Clinics_Activity.class){
					result = new Intent(ctx, Clinics_Activity.class);
				}
				break;
			case R.id.nav_about:
				if(ctx.getClass() != About_Activity.class){
					result = new Intent(ctx, About_Activity.class);
				}
				break;
			case R.id.nav_logout:
				break;
			default:
				break;
		}
		return result;
	}

}
