package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.content.Context;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class List_Fragment extends DialogFragment {

	private Activity parent;
	private int stackNum, type;
	private Context current_ctx;
	private ArrayList ALL_ITEMS;

	public static final int CLINIC = 1, EVENT = 2;

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

		current_ctx = this.getActivity();
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater, container, savedInstanceState);
		final View view = inflater.inflate(R.layout.list_layout, container, false);

		final ListView list = (ListView) view.findViewById(R.id.list);
		switch (type)
		{
			case EVENT:
				if(ALL_ITEMS != null && !ALL_ITEMS.isEmpty()) {
					list.setAdapter(new List_Adapter(ALL_ITEMS, parent, List_Adapter.Type.Event));
				}
				break;
			case CLINIC:
				if(ALL_ITEMS != null && !ALL_ITEMS.isEmpty()) {
					list.setAdapter(new List_Adapter(ALL_ITEMS, parent, List_Adapter.Type.Clinic));
				}
				break;
		}

		view.findViewById(R.id.BTN_Search).setOnClickListener(new View.OnClickListener()
		{
			@Override
			public void onClick(View v)
			{
				DialogFragment fragment = Event_Calendar_Fragment.init(stackNum);
				((Event_Calendar_Fragment)fragment).setItems(ALL_ITEMS);
				FragmentManager manager = parent.getFragmentManager();
				FragmentTransaction transaction = manager.beginTransaction();
				Fragment prev = manager.findFragmentByTag("embed");
				if(prev!=null){
					transaction.remove(prev);
				}
				transaction.add(R.id.content ,fragment, "embed");
				transaction.commit();
			}
		});

		return view;
	}

	public void setItems(ArrayList es) {
		ALL_ITEMS = es;
	}
}
