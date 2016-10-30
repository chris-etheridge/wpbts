package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.TextView;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;
import java.util.Date;

import cz.msebera.android.httpclient.Header;

public class List_Fragment extends DialogFragment{

	private Activity parent;
	private int stackNum, type;
	public static final int CLINIC = 1, EVENT = 2;

	private static final Events EVENTS_HELPER = new Events();

	public static List_Fragment init(int stackNum, int type){
		List_Fragment fragment = new List_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		args.putInt("type", type);
		fragment.setArguments(args);

		return fragment;
	}

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

		parent = getActivity();
		stackNum = getArguments().getInt("stackNum");
		type = getArguments().getInt("type");
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		View view = inflater.inflate(R.layout.event_list_layout, container, false);

		final ListView list = (ListView) view.findViewById(R.id.list);
		switch (type)
		{
			case EVENT:
				EVENTS_HELPER.GetAllEvents( new JsonHttpResponseHandler() {
					@Override
					public void onSuccess(int statusCode, Header[] headers, JSONArray a) {
						try {
							ArrayList es = Event.EventsFromJsonArray(a);

							list.setAdapter(new List_Adapter(es, parent, List_Adapter.Type.Event));
						} catch (JSONException e) {
							e.printStackTrace();
						} catch (ParseException e) {
							e.printStackTrace();
						}
					}
				});

				break;
			case CLINIC:
				list.setAdapter(new List_Adapter(new ArrayList(), parent, List_Adapter.Type.Event));
				break;
		}

			view.findViewById(R.id.TXT_Error).setVisibility(View.GONE);
			view.findViewById(R.id.list).setVisibility(View.VISIBLE);

/*		else {
			view.findViewById(R.id.TXT_Error).setVisibility(View.VISIBLE);
			view.findViewById(R.id.list).setVisibility(View.GONE);

			if(type == CLINIC){
				((TextView)view.findViewById(R.id.TXT_Error)).setText("No Clinics Found.\nPlease check your network connection.");
			}
		}*/

		return view;
	}
}
