package com.peachtree.wpbapp.Activity;

import android.app.Activity;
import android.app.DialogFragment;
import android.app.Fragment;
import android.app.FragmentManager;
import android.app.FragmentTransaction;
import android.content.Context;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import com.loopj.android.http.JsonHttpResponseHandler;
import com.peachtree.wpbapp.Core.Events;
import com.peachtree.wpbapp.Core.Networking;
import com.peachtree.wpbapp.Entities.Clinic;
import com.peachtree.wpbapp.R;
import com.peachtree.wpbapp.Entities.Event;
import com.peachtree.wpbapp.layout_Handlers.List_Adapter;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.InputStream;
import java.text.ParseException;
import java.util.ArrayList;

import cz.msebera.android.httpclient.Header;

public class List_Fragment extends DialogFragment {

    private Activity parent;
    private int stackNum, type;
    private Context current_ctx;
    private ArrayList ALL_ITEMS, FILTERED_ITEMS;
    private boolean isSearch = false;
    private String search;

    public static final int CLINIC = 1, EVENT = 2;

    public static List_Fragment init(int stackNum, int type) {
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
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        super.onCreateView(inflater, container, savedInstanceState);
        final View view = inflater.inflate(R.layout.list_layout, container, false);

        final ImageView eventImageView = (ImageView) view.findViewById(R.id.event_img);

        final ListView list = (ListView) view.findViewById(R.id.list);

        ArrayList instance_array = ALL_ITEMS;

        if (isSearch) {
            instance_array = FILTERED_ITEMS;
            ((EditText) view.findViewById(R.id.TXT_search)).setText(search);
        }
        switch (type) {
            case EVENT:
                if (instance_array != null && !instance_array.isEmpty()) {
                    list.setAdapter(new List_Adapter(instance_array, parent, List_Adapter.Type.Event));
                }
                break;
            case CLINIC:
                if (instance_array != null && !instance_array.isEmpty()) {
                    list.setAdapter(new List_Adapter(instance_array, parent, List_Adapter.Type.Clinic));
                }
                break;
        }

        view.findViewById(R.id.BTN_Search).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                TextView search_text = ((TextView) view.findViewById(R.id.TXT_search));

                if (search_text.getText().length() > 0) {
                    List_Fragment filter_Fragment = List_Fragment.init(stackNum, type);
                    filter_Fragment.setItems(ALL_ITEMS);
                    filter_Fragment.setSearch(true, search_text.getText(), type);
                    FragmentTransaction transaction = parent.getFragmentManager().beginTransaction();
                    Fragment prev = parent.getFragmentManager().findFragmentByTag("embed");
                    if (prev != null) {
                        transaction.remove(prev);
                    }
                    transaction.add(R.id.content, filter_Fragment, "embed");
                    transaction.commit();
                } else {
                    switch (type) {
                        case EVENT:
                            ((Home_Activity) parent).switchFragment(R.id.nav_event_list);
                            break;
                        case CLINIC:
                            ((Home_Activity) parent).switchFragment(R.id.nav_event_list);
                            break;
                    }
                }
            }
        });

        return view;
    }

    public void setItems(ArrayList es) {
        ALL_ITEMS = es;
    }

    public void setSearch(Boolean isSearch, CharSequence search, int type) {
        this.isSearch = isSearch;
        this.search = search.toString();

        FILTERED_ITEMS = new ArrayList();
        for (Object item : ALL_ITEMS) {
            switch (type) {
                case EVENT:
                    if (((Event) item).getTitle().toLowerCase().contains(search.toString().toLowerCase()) || ((Event) item).getDescription().toLowerCase().contains(search.toString().toLowerCase())) {
                        FILTERED_ITEMS.add(item);
                    }
                    break;
                case CLINIC:
                    if (((Clinic) item).getName().toLowerCase().contains(search.toString().toLowerCase()) || ((Clinic) item).getDescription().toLowerCase().contains(search.toString().toLowerCase())) {
                        FILTERED_ITEMS.add(item);
                    }
            }
        }
    }
}
