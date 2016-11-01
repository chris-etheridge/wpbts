package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.layout_Handlers.WBCalendar;

import java.util.ArrayList;

public class Event_Calendar_Fragment extends DialogFragment
{

	private Activity parent;
	private int stackNum;
	private ArrayList<Event> events = null;

	public static Event_Calendar_Fragment init(int stackNum){
		Event_Calendar_Fragment fragment = new Event_Calendar_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState)
	{
		super.onCreateView(inflater, container, savedInstanceState);
		View view = inflater.inflate(R.layout.event_calendar_layout, container, false);

		((WBCalendar)view.findViewById(R.id.calendar)).setEvents(events);

		return view;
	}

	public void setEvents(ArrayList<Event> e){
		events = e;
	}
}
