package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Context;
import android.os.Bundle;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Event;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class Event_Info_Fragment extends DialogFragment
{

	private Activity parent;
	private int id, array_index;
	private ArrayList<Event> events;
	private Event event;
	private float mCurrenty, mCurrentx;

	//private Events EVENTS_HELPER;

	private Context CURRENT_CONTEXT;

	public static Event_Info_Fragment init(int id){
		Event_Info_Fragment fragment = new Event_Info_Fragment();

		Bundle args = new Bundle();
		args.putInt("id", id);
		fragment.setArguments(args);

		return fragment;
	}
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
		parent = getActivity();
		id = getArguments().getInt("id");
		if(events!=null){
			int i = 0;
			while (i < events.size() && event == null){
				if(events.get(i).getId() == id){
					event = events.get(i);
					array_index = i;
				}
				i++;
			}
		}
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.event_info_layout, container, false);

		mCurrenty = view.getY();
		mCurrenty = view.getX();
		final float originalY = mCurrenty;
		final float originalX = mCurrentx;


		// get all of our fields
		TextView title = (TextView)view.findViewById(R.id.event_title);
		TextView desc = (TextView)view.findViewById(R.id.TXT_details);
		TextView date = (TextView)view.findViewById(R.id.TXT_date);
		TextView address = (TextView)view.findViewById(R.id.TXT_Address);
		ImageView image = (ImageView)view.findViewById(R.id.IMG_event);

		title.setText(event.getTitle());
		desc.setText(event.getDescription());
		date.setText("Date: " + Event.getDateString(event.getDate()));
		address.setText("Address: " + event.getAddress());

		view.findViewById(R.id.pull_grip).setOnTouchListener(new View.OnTouchListener()
		{
			private float offset;
			private int threshold = (int)(getDialog().getWindow().getWindowManager().getDefaultDisplay().getHeight() * 2/3.0);

			@Override
			public boolean onTouch(View v, MotionEvent event)
			{
				int action = event.getAction();
				if(action == MotionEvent.ACTION_DOWN){
					offset= mCurrenty - event.getRawY();
				}else if(action == MotionEvent.ACTION_MOVE){
					mCurrenty = (int)(event.getRawY() + offset);
					if(mCurrenty > originalY)
					{
						view.setY(mCurrenty);
					}
				}else if(action == MotionEvent.ACTION_UP){

					if(mCurrenty > originalY + threshold){
						dismiss();
					}else{
						mCurrenty = originalY;
						view.setY(mCurrenty);
					}
				}
				return true;
			}
		});

		view.findViewById(R.id.dragable_layout).setOnTouchListener(new View.OnTouchListener()
		{

			private int offset;
			private int threshold = (int)(getDialog().getWindow().getWindowManager().getDefaultDisplay().getWidth() /2);
			@Override
			public boolean onTouch(View v, MotionEvent event)
			{
				int action = event.getAction();
				if(action == MotionEvent.ACTION_DOWN){

				}else if (action == MotionEvent.ACTION_MOVE){

				}else if (action == MotionEvent.ACTION_UP){

				}

				return true;
			}
		});

		return view;
	}

	@Override
	public void onStart(){
		super.onStart();
		WindowManager wm = (WindowManager)parent.getSystemService(Context.WINDOW_SERVICE);
		Display display = wm.getDefaultDisplay();
		getDialog().getWindow().setBackgroundDrawable(null);
		getDialog().getWindow().setLayout(display.getWidth() - 50, display.getHeight() - 50);

	}

	public void loadEvents(ArrayList<Event> ev){
		events = ev;
	}
}
