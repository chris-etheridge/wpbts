package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.content.Context;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.os.Bundle;
import android.util.Log;
import android.view.Display;
import android.view.LayoutInflater;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.TextView;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.Entities.User;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Core.Util;
import com.peachtree.wpbapp.Entities.Event;

import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;

import cz.msebera.android.httpclient.Header;

public class Event_Info_Fragment extends DialogFragment
{

	private Activity parent;
	private int id;
	private Event event;
	private float mCurrenty;

	private Events EVENTS_HELPER;

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

		EVENTS_HELPER = new Events(this.getContext());

		load_event();
    }

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.event_info_layout, container, false);

		mCurrenty = view.getY();
		final float originalY = mCurrenty;

		EVENTS_HELPER.GetEventById(id, new JsonHttpResponseHandler(){
			@Override
			public void onSuccess(int statusCode, Header[] headers, JSONObject o) {
					Log.d("API_E", o.toString());

			}

			@Override
			public void onFailure(int statusCode, Header[] headers, Throwable throwable, JSONObject response) {
				// handle the error here
				int code = -1;

				try {
					code = Integer.parseInt(response.getString("code"));
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}
		});

		view.findViewById(R.id.pull_grip).setOnTouchListener(new View.OnTouchListener()
		{
			private float offset;

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

					if(mCurrenty > originalY + 1000){
						dismiss();
					}else{
						mCurrenty = originalY;
						view.setY(mCurrenty);
					}
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

	private void load_event(){
		//TO-DO
	}
}
