package com.peachtree.wpbapp.layout_Handlers;

import android.app.Application;
import android.app.DialogFragment;
import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.GridView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.entities.Event;

import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;

/**
 * Created by Tyron on 10/28/2016.
 */
public class WBCalendar extends LinearLayout
{

	private ArrayList<Event> events;
	private Context ctx;
	private Calendar currentDate = Calendar.getInstance();
	private final int DAYS_COUNT = 42;
	private final String FORMAT = "MMMM yyyy";
	private GridView grid;
	private TextView month_title;


	public WBCalendar(Context ctx){
		super(ctx);
	}

	public WBCalendar(Context ctx, AttributeSet attrs){
		super(ctx, attrs);
		initControl(ctx);
	}

	public WBCalendar(Context context, AttributeSet attrs, int defStyleAttr)
	{
		super(context, attrs, defStyleAttr);
		initControl(context);
	}

	private void initControl(Context ctx){
		LayoutInflater inflater = (LayoutInflater)ctx.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		inflater.inflate(R.layout.calendar, this);

		grid = (GridView) findViewById(R.id.days_grid);
		month_title = (TextView) findViewById(R.id.TXT_month);

		updateCalendar();
	}

	private void updateCalendar(){
		ArrayList<Date> cells = new ArrayList<>();
		Calendar calendar = (Calendar)currentDate.clone();

		calendar.set(Calendar.DAY_OF_MONTH, 1);
		int monthBeginningCell = calendar.get(Calendar.DAY_OF_WEEK) - 1;
		calendar.add(Calendar.DAY_OF_MONTH, -monthBeginningCell);

		while(cells.size() < DAYS_COUNT){
			cells.add(calendar.getTime());
			calendar.add(calendar.DAY_OF_MONTH, 1);
		}

		grid.setAdapter(new Calendar_Adapter(getContext(), cells, events));

		SimpleDateFormat format = new SimpleDateFormat(FORMAT);
		month_title. setText(format.format(currentDate.getTime()));
	}

	private class Calendar_Adapter extends ArrayAdapter<Date>
	{
		private ArrayList<Event> events;

		private LayoutInflater inflater;

		public Calendar_Adapter(Context ctx, ArrayList<Date> cells, ArrayList<Event> events)
		{

			super(ctx, R.layout.calendar_day, cells);
			this.events = events;

			inflater = LayoutInflater.from(ctx);
		}

		@Override
		public View getView(int position, View view, ViewGroup parent)
		{
			Date date = getItem(position);
			int day = date.getDate();
			int month = date.getMonth();
			int year = date.getYear();

			Date today = new Date();

			if(view == null){
				view = inflater.inflate(R.layout.calendar_day, parent, false);
			}

			view.setBackgroundResource(0);

			((TextView)view).setTextColor(Color.BLACK);

			if(month != today.getMonth() || year != today.getYear()){
				((TextView)view).setTextColor(getResources().getColor(R.color.colorAccent));
			}else if(day == today.getDate()){
				view.setBackgroundColor(getResources().getColor(R.color.colorAccent));
			}else

			if(events != null){
				for(Event event: events){
					if(event.getDate().getDate() == day && event.getDate().getMonth() == month && event.getDate().getYear() == year){
						if(month != today.getMonth() || year != today.getYear()){
							view.setBackgroundColor(getResources().getColor(R.color.colorFieldBG));
						}else
						{
							view.setBackgroundColor(getResources().getColor(R.color.colorPrimary));
						}
						((TextView)view).setTextColor(getResources().getColor(R.color.colorBG));
					}
				}
			}

			((TextView)view).setText(String.valueOf(day));

			return view;
		}
	}

}