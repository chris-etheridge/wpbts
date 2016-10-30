package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ExpandableListView;

import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.layout_Handlers.Accordion_Handler;

public class About_Fragment extends DialogFragment
{
	private Accordion_Handler accordion_handler;
	private final int ABOUT_SRC_FILE = R.raw.about_items;
	private static int group_pos = -1;
	private ExpandableListView expandableListView;
	private int stackNum; //To be used later.
	private Activity parent;

	public static About_Fragment init(int stackNum){
		About_Fragment fragment = new About_Fragment();

		Bundle args = new Bundle();
		args.putInt("stackNum", stackNum);
		fragment.setArguments(args);

		return fragment;
	}

	@Override
	public void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);

		stackNum = getArguments().getInt("stackNum");
		parent = getActivity();
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState){
		super.onCreateView(inflater,container,savedInstanceState);
		View view = inflater.inflate(R.layout.about_layout, container, false);

		accordion_handler = new Accordion_Handler(parent, ABOUT_SRC_FILE);

		(expandableListView = ((ExpandableListView)view.findViewById(R.id.EXP_about))).setAdapter(accordion_handler);
		expandableListView.setOnGroupExpandListener(new ExpandableListView.OnGroupExpandListener()
		{
			public void onGroupExpand(int i)
			{
				if(expandableListView.isGroupExpanded(i))
				{
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_DOWN).setVisibility(View.GONE);
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_UP).setVisibility(View.VISIBLE);
				}
				if (group_pos >= 0 && i!= group_pos)
				{
					expandableListView.collapseGroup(group_pos);
				}

				group_pos = i;
			}
		});
		expandableListView.setOnGroupCollapseListener(new ExpandableListView.OnGroupCollapseListener()
		{
			@Override
			public void onGroupCollapse(int i)
			{
				if(i==group_pos)
				{
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_UP).setVisibility(View.GONE);
					expandableListView.findViewWithTag("Group_" + i).findViewById(R.id.ARROW_DOWN).setVisibility(View.VISIBLE);
				}
			}
		});

		return view;
	}
}
