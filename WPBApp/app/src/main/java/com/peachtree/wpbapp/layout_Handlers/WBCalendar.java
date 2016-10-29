package com.peachtree.wpbapp.layout_Handlers;

import android.app.Activity;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.content.Context;
import android.graphics.Color;
import android.util.AttributeSet;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.GridView;
import android.widget.ImageButton;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.activity.Event_Info_Fragment;
import com.peachtree.wpbapp.core.Util;
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
	private Event selected;
	private Context ctx;
	private Calendar currentDate = Calendar.getInstance();
	private final int DAYS_COUNT = 42;
	private final String FORMAT = "MMMM yyyy";
	private GridView grid;
	private TextView month_title, description;
	private ImageButton btn_next, btn_prev;
	private Button btn_view;
	private Util util = new Util();


	public WBCalendar(Context ctx){
		super(ctx);
		this.ctx = ctx;
	}

	public WBCalendar(Context ctx, AttributeSet attrs){
		super(ctx, attrs);
		this.ctx = ctx;
		initControl(ctx);
	}

	public WBCalendar(Context ctx, AttributeSet attrs, int defStyleAttr)
	{
		super(ctx, attrs, defStyleAttr);
		this.ctx = ctx;
		initControl(ctx);
	}

	private void initControl(Context ctx){
		LayoutInflater inflater = (LayoutInflater)ctx.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
		inflater.inflate(R.layout.calendar, this);

		events = util.getEvents();

		grid = (GridView) findViewById(R.id.days_grid);
		month_title = (TextView) findViewById(R.id.TXT_month);
		btn_next = (ImageButton)findViewById(R.id.BTN_next);
		btn_prev = (ImageButton)findViewById(R.id.BTN_prev);
		description = (TextView)findViewById(R.id.TXT_description);
		btn_view = (Button) findViewById(R.id.BTN_view);

		setOnClicksListeners();

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

	private void setOnClicksListeners(){

		btn_next.setOnClickListener(new OnClickListener()
		{
			@Override
			public void onClick(View view)
			{
				currentDate.add(Calendar.MONTH, 1);
				updateCalendar();
			}
		});

		btn_prev.setOnClickListener(new OnClickListener()
		{
			@Override
			public void onClick(View view)
			{
				currentDate.add(Calendar.MONTH, -1);
				updateCalendar();
			}
		});

		grid.setOnItemClickListener(new AdapterView.OnItemClickListener()
		{
			@Override
			public void onItemClick(AdapterView<?> adapterView, View view, int i, long l)
			{
				if(view.getTag() != null){
					selected = null;
					view.setBackground(getResources().getDrawable(R.drawable.selected_event_bg));
					int x = 0;
					while((selected == null || selected.getId() != (int)view.getTag()) && x < events.size()){
						selected = events.get(x);
						i++;
					}
					description.setText(generateDescription(selected));
				}
			}
		});

		btn_view.setOnClickListener(new OnClickListener()
		{
			@Override
			public void onClick(View view)
			{
				if(selected!=null)
				{
					FragmentManager manager = ((Activity) ctx).getFragmentManager();
					FragmentTransaction transaction = manager.beginTransaction();
					Event_Info_Fragment event_dialog = Event_Info_Fragment.init(selected.getId());
					event_dialog.show(transaction, "event_dialog");
				}
			}
		});
	}

	private String generateDescription(Event event){
		SimpleDateFormat dayFormat = new SimpleDateFormat("EEEE dd");
		String output = String.format("%s\n%s\n%s\n%s", event.getTitle(), event.getAddress(), event.getType(), dayFormat.format(event.getDate()));
		return output;
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
		public View getView(final int position, View view, ViewGroup parent)
		{
			Date date = getItem(position);
			int day = date.getDate();
			int month = date.getMonth();
			int year = date.getYear();

			Date today = new Date();
			Date current = currentDate.getTime();

			if(view == null){
				view = inflater.inflate(R.layout.calendar_day, parent, false);
			}

			view.setBackgroundResource(0);

			((TextView)view).setTextColor(Color.BLACK);

			if(month != current.getMonth() || year != current.getYear()){
				((TextView)view).setTextColor(getResources().getColor(R.color.colorAccent));
			}else if(day == today.getDate() && month == today.getMonth() && year == today.getYear()){
				view.setBackground(getResources().getDrawable(R.drawable.current_date_bg));
			}else

			if(events != null){
				for(Event event: events){
					if(event.getDate().getDate() == day && event.getDate().getMonth() == month && event.getDate().getYear() == year){
						if(month != today.getMonth() || year != today.getYear()){
							view.setBackground(getResources().getDrawable(R.drawable.event_day_bg_secondary));
						}else
						{
							view.setBackground(getResources().getDrawable(R.drawable.event_day_bg));
						}
						((TextView)view).setTextColor(getResources().getColor(R.color.colorBG));
						view.setTag(event.getId());
					}
				}
			}

			((TextView)view).setText(String.valueOf(day));

			return view;
		}
	}

}